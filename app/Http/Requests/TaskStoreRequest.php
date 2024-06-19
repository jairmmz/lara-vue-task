<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends BaseRequest
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
            'name' => 'required',
            'project_id' => 'required|exists:projects,id',
            'member_id.*' => 'required|exists:members,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'project_id.required' => 'El proyecto es requerido',
            'project_id.exists' => 'El proyecto no existe',
            'member_id.required' => 'El miembro es requerido',
            'member_id.exists' => 'El miembro no existe',
            'member_id.*.exists' => 'El miembro no existe'
        ];
    }
}
