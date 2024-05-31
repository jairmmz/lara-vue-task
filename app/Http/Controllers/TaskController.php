<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Jobs\CreateTaskMemberJob;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function createTask(CreateTaskRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $task = Task::create([
                'project_id' => $request->input('project_id'),
                'name' => $request->input('name'),
                'status' => Task::NOT_STARTED,
            ]);

            CreateTaskMemberJob::dispatch($request->input('member_id'), $task);

            DB::commit();

            return response()->json([
                'message' => 'Tarea creada correctamente'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear la tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
