<?php

namespace App\Services;

use App\Events\CreateProjectEvent;
use App\Models\Project;
use App\Models\TaskProgress;

class ProjectService
{
    public function getProject(string $slug ): Project | null
    {
        $project = Project::with(['tasks.taskMembers.member'])->where('slug', $slug)->first();

        return $project;
    }

    public function index(?string $query): mixed
    {
        $projects = Project::with(['taskProgress']);

        if ($query) {
            $projects->where('name', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return $projects->paginate(10);
    }

    public function store(array $data): Project
    {
        $project = Project::create([
            'name' => $data['name'],
            'status' => Project::NOT_STARTED,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'slug' => Project::generateSlug($data['name'])
        ]);

        CreateProjectEvent::dispatch($project);

        return $project;
    }

    public function update(Project $project, array $data): Project
    {
        $project->update([
            'name' => $data['name'],
            'status' => $data['status'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'slug' => Project::generateSlug($data['name'])
        ]);

        return $project;
    }

    public function pinnedProject(array $data): void
    {
        TaskProgress::where('project_id', $data['project_id'])->update([
            'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD
        ]);
    }

    public function count(): int
    {
        return Project::count();
    }
}
