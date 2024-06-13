<?php

namespace App\Http\Controllers;

use App\Events\CreateProjectEvent;
use App\Http\Requests\PinnetProjectRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Models\TaskProgress;
use App\Services\ProjectService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) { }

    public function getProject(string $slug ): JsonResponse
    {
        $project = $this->projectService->getProject($slug);

        if (empty($project)) {
            return $this->notFound();
        }

        return $this->success('Proyecto recuperado exitosamente.', $project);
    }

    public function index(Request $request): JsonResponse
    {
        $query = $request->get('query');

        $projects = $this->projectService->index($query);

        return $this->success('Proyectos recuperados exitosamente.', $projects);
    }

    public function store(ProjectStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $project = $this->projectService->store($request->validated());
            DB::commit();
            return $this->success('Proyecto creado exitosamente.', $project);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado.', $e->getMessage());
        }
    }

    public function update(Project $project, ProjectUpdateRequest $request): JsonResponse
    {
        $project = $this->projectService->update($project, $request->validated());

        return $this->success('Proyecto actualizado exitosamente.', $project);
    }

    public function pinnedProject(PinnetProjectRequest $request): JsonResponse
    {
        $this->projectService->pinnedProject($request->validated());

        return $this->success('El proyecto ha sido fijado en el dashboard.');
    }

    public function countProject(): JsonResponse
    {
        $count = $this->projectService->count();

        return $this->success('Proyectos contados exitosamente.', $count);
    }
}
