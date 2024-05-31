<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends BaseRequest
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
            'status' => 'required|in:0,1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'status.required' => 'El estado es requerido',
            'status.in' => 'El estado debe ser 0, 1 o 2',
            'start_date.required' => 'La fecha de inicio es requerida',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
            'end_date.required' => 'La fecha de fin es requerida',
            'end_date.date' => 'La fecha de fin debe ser una fecha válida',
        ];
    }
}
