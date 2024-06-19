<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetProjectChartDataRequest extends BaseRequest
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
            'project_id' => 'required|exists:task_progress,project_id'
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'El proyecto es requerido',
            'project_id.exists' => 'El proyecto no existe',
        ];
    }
}
