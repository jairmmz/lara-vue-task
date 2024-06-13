<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Jobs\CreateTaskMemberJob;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) { }

    public function createTask(CreateTaskRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $task = $this->taskService->create($request->validated());
            DB::commit();

            return $this->success('Tarea creada', $task);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado',$e->getMessage());
        }
    }

    public function taskToNotStartedToPending(Task $task): JsonResponse
    {
        $this->taskService->changeTaskStatus($task->id, Task::PENDING);
        return $this->success('La tarea se cambió a pendiente');
    }

    public function taskToPendingToComplete(Task $task): JsonResponse
    {
        $this->taskService->changeTaskStatus($task->id, Task::COMPLETED);
        return $this->success('La tarea se cambió a completada');
    }

    public function taskToPendingToNotStarted(Task $task): JsonResponse
    {
        $this->taskService->changeTaskStatus($task->id, Task::NOT_STARTED);
        return $this->success('La tarea se cambió a no iniciada');
    }

    public function taskToCompletedToPending(Task $task): JsonResponse
    {
        $this->taskService->changeTaskStatus($task->id, Task::PENDING);
        return $this->success('La tarea se cambió a pendiente');
    }

    public function taskToCompletedToNotStarted(Task $task): JsonResponse
    {
        $this->taskService->changeTaskStatus($task->id, Task::NOT_STARTED);
        return $this->success('La tarea se cambió a no iniciada');
    }
}
