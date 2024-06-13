<?php

namespace App\Services;

use App\Jobs\CreateTaskMemberJob;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function create(array $data): Task
    {
        $task = Task::create([
            'project_id' => $data['project_id'],
            'name' => $data['name'],
            'status' => Task::NOT_STARTED,
        ]);

        CreateTaskMemberJob::dispatch($data['member_id'], $task);

        return $task;
    }

    public static function changeTaskStatus($task, $status): void
    {
        Task::where('id', $task->id)->update(['status' => $status]);
    }
}
