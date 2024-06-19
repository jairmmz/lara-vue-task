<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ProjectDto;
use App\Http\Requests\GetProjectChartDataRequest;
use App\Http\Requests\PinnetProjectRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
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
            $project = $this->projectService->store(ProjectDto::requestStore($request));
            DB::commit();
            return $this->success('Proyecto creado exitosamente.', $project, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado.', $e->getMessage());
        }
    }

    public function update(ProjectUpdateRequest $request, Project $project): JsonResponse
    {
        $project = $this->projectService->update($project, ProjectDto::requestUpdate($request));

        return $this->success('Proyecto actualizado exitosamente.', $project);
    }

    public function pinnedProject(PinnetProjectRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->projectService->pinnedProject($request->validated('project_id'));
            DB::commit();
            return $this->success('El proyecto ha sido fijado en el dashboard.');
        } catch (Exception $e) {
            // Mandar el $e->getMesssage() como evento o job por correo electrónico al administrador o enviarlo al Log.
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado.');
        }
    }

    public function countProject(): JsonResponse
    {
        $count = $this->projectService->count();

        return $this->success('Proyectos contados exitosamente.', $count);
    }

    public function getPinnedProject()
    {
        $project = $this->projectService->getPinnedProject();

        return $this->success('Proyecto fijado recuperado exitosamente.', $project);
    }

    public function getProjectChartData(GetProjectChartDataRequest $request)
    {
        $project = $this->projectService->projectChartData($request->validated('project_id'));

        return $this->success('Datos de proyectos recuperados exitosamente.', $project);
    }
}
