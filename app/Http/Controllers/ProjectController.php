<?php

namespace App\Http\Controllers;

use App\Events\CreateProjectEvent;
use App\Http\Requests\PinnetProjectRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Models\TaskProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function getProject(string $slug ): JsonResponse
    {
        $project = Project::with(['tasks.taskMembers.member'])->where('slug', $slug)->first();

        if (!$project) {
            return response()->json([
                'message' => 'Proyecto no encontrado'
            ], 404);
        }

        return response()->json([
            'project' => $project
        ], 200);
    }

    public function index(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $projects = Project::with(['taskProgress']);

        if (!empty($query)) {
            $projects->where('name', 'like', "%$query%")->orderBy('id', 'desc');
        }

        return response()->json([
            'projects' => $projects->paginate(10)
        ], 200);
    }

    public function store(ProjectStoreRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $project = Project::create([
                'name' => $request->input('name'),
                'status' => Project::NOT_STARTED,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'slug' => Project::generateSlug($request->input('name'))
            ]);

            CreateProjectEvent::dispatch($project);

            return response()->json([
                'message' => 'Proyecto creado exitosamente'
            ], 201);
        });
    }

    public function update(Project $project, ProjectUpdateRequest $request): JsonResponse
    {
        $project->update([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'slug' => Project::generateSlug($request->input('name'))
        ]);

        return response()->json([
            'message' => 'Proyecto actualizado exitosamente',
        ], 200);
    }

    public function pinnedProject(PinnetProjectRequest $request): JsonResponse
    {
        TaskProgress::where('project_id', $request->input('project_id'))->update([
            'pinned_on_dashboard' => TaskProgress::PINNED_ON_DASHBOARD
        ]);

        return response()->json([
            'message' => 'El proyecto ha sido fijado en el dashboard'
        ], 200);
    }
}
