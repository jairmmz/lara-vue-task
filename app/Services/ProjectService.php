<?php

namespace App\Services;

use App\DataTransferObjects\ProjectDto;
use App\Events\CreateProjectEvent;
use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\TaskProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectService
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function getProject(string $slug ): ProjectDetailResource | null
    {
        $project = Project::with(['tasks.taskMembers.member', 'taskProgress'])->where('slug', $slug)->first();

        return ProjectDetailResource::make($project);
    }

    public function index(?string $query): mixed
    {
        $projects = Project::with(['taskProgress']);

        if ($query) {
            $projects->where('name', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return $projects->paginate(5);
    }

    public function store(ProjectDto $dto): ProjectResource
    {
        $project = Project::create([
            'name' => $dto->name,
            'status' => Project::NOT_STARTED,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'slug' => $this->generateSlug($dto->name)
        ]);

        $count = Project::count();

        CreateProjectEvent::dispatch($project, $count);

        return ProjectResource::make($project);
    }

    public function update(Project $project, ProjectDto $dto): ProjectResource
    {
        $project->update([
            'name' => $dto->name,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'slug' => Project::generateSlug($dto->name)
        ]);

        return ProjectResource::make($project);
    }

    public function pinnedProject(string $projectId): void
    {
        TaskProgress::where('pinned_on_dashboard', TaskProgress::PINNED_ON_DASHBOARD)->update([
            'pinned_on_dashboard' => TaskProgress::NOT_PINNED_ON_DASHBOARD
        ]);

        TaskProgress::where('project_id', $projectId)->update([
            'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD
        ]);
    }

    public function count(): int
    {
        return Project::count();
    }

    public function getPinnedProject(): mixed
    {
        $project = DB::table('task_progress')
        ->join('projects', 'task_progress.project_id', '=', 'projects.id')
        ->select('projects.id', 'projects.name')
        ->where('task_progress.pinned_on_dashboard', TaskProgress::PINNED_ON_DASHBOARD)
        ->first();

        if (!is_null($project)) {
            return $project;
        }

        return null;
    }

    public function projectChartData(string $proyectId): array
    {
        $taskProgress = TaskProgress::where('project_id', $proyectId)
        ->select('progress')
        ->first();

        $taskArray = $this->taskService->countCompletedAndPendingTask($proyectId);

        return ['tasks' => $taskArray, 'progress' => intval($taskProgress->progress)];
    }

    function generateSlug(string $name): string
    {
        return Str::slug($name) . '-' . Str::random(10) . '-' . time();
    }

}
