<?php

namespace App\Services;

use App\DataTransferObjects\TaskDto;
use App\Events\TrackCompletedAndPendingTask;
use App\Events\TrackProjectProgress;
use App\Http\Resources\TaskResource;
use App\Jobs\CreateTaskMemberJob;
use App\Models\Task;
use App\Models\TaskProgress;

class TaskService
{
    public function create(TaskDto $dto): TaskResource
    {
        $task = Task::create([
            'project_id' => $dto->project_id,
            'name' => $dto->name,
            'status' => Task::NOT_STARTED,
        ]);

        CreateTaskMemberJob::dispatch($dto->member_id, $task);

        return TaskResource::make($task);
    }

    public static function changeTaskStatus(string $taskId, int $status): void
    {
        Task::where('id', $taskId)->update(['status' => $status]);
    }

    function countProjectTask(string $projectId): int
    {
        return Task::where('project_id', $projectId)->count();
    }

    function countCompletedTask(string $projectId): int
    {
        return Task::where('project_id', $projectId)
        ->where('status', Task::COMPLETED)
        ->count();
    }

    function aroundRumber(int $number): string
    {
        if (strpos($number, '.')) {
            $position = strpos($number, '.') + 1;
            return substr($number, 0, $position + 1);
        } else {
            return $number;
        }
    }

    function countCompletedAndPendingTask(string $projectId): array
    {
        $task = Task::where('project_id', $projectId)->get();

        $pending = 0;
        $completed = 0;

        foreach($task as $row) {
            if (intval($row->status) === Task::PENDING) {
                $pending++;
            }
            
            if (intval($row->status) === Task::COMPLETED) {
                $completed++;
            }
        }

        return [$pending, $completed];
    }

    function handleProjectProgress(string $projectId): string
    {
        $totalTask = $this->countProjectTask($projectId);
        $totalCompletedTask = $this->countCompletedTask($projectId);

        $progress = $this->aroundRumber(($totalCompletedTask * 100) / $totalTask);
        $taskProgress = TaskProgress::where('project_id', $projectId)->first();

        if (!is_null($taskProgress)) {
            $taskProgress->where('project_id', $projectId)->update([
                'progress' => $progress
            ]);

            $this->countCompletedAndPendingTask($projectId);

            $tasks = $this->countCompletedAndPendingTask($projectId);

            // TrackCompletedAndPendingTask::dispatch($tasks);
            // TrackProjectProgress::dispatch($progress);

            return $progress;
        }
    }
}
