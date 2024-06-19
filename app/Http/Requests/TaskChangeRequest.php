<?php

namespace App\Http\Requests;

class TaskChangeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'project_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'El id de la tarea es requerido',
            'task_id.exists' => 'La tarea no existe',
            'project_id.required' => 'El id del proyecto es requerido'
        ];
    }
}
