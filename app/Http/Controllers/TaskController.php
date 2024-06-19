<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\TaskDto;
use App\Http\Requests\TaskChangeRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) { }

    public function createTask(TaskStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $task = $this->taskService->create(TaskDto::requestStore($request));
            DB::commit();

            return $this->success('Tarea creada exitosamente.', $task);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado.',$e->getMessage());
        }
    }

    public function taskToNotStartedToPending(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::PENDING);
        $this->taskService->handleProjectProgress($request->validated('project_id'));
        return $this->success('La tarea se cambió a pendiente');
    }

    public function taskToPendingToComplete(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::COMPLETED);
        $this->taskService->handleProjectProgress($request->validated('project_id'));
        return $this->success('La tarea se cambió a completada');
    }

    public function taskToPendingToNotStarted(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::NOT_STARTED);
        return $this->success('La tarea se cambió a no iniciada');
    }

    public function taskToCompletedToPending(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::PENDING);
        $this->taskService->handleProjectProgress($request->validated('project_id'));
        return $this->success('La tarea se cambió a pendiente');
    }

    public function taskToNotStartedToCompleted(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::COMPLETED);
        return $this->success('La tarea se cambió a completada');
    }

    public function taskToCompletedToNotStarted(TaskChangeRequest $request): JsonResponse
    {
        $this->taskService->changeTaskStatus($request->validated('task_id'), Task::NOT_STARTED);
        return $this->success('La tarea se cambió a no iniciada');
    }
}
