<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|in:full-time,part-time,remote,hybrid',
            'categoryId' => 'required|uuid|exists:job_categories,id',
            'companyId' => 'required|uuid|exists:companies,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title cannot exceed 255 characters',
            'description.required' => 'Description is required',
            'location.required' => 'Location is required',
            'salary.required' => 'Salary is required',
            'salary.numeric' => 'Salary must be a valid number',
            'salary.min' => 'Salary cannot be negative',
            'type.required' => 'Type is required',
            'type.in' => 'Invalid job type selected',
            'categoryId.required' => 'Job Category is required',
            'categoryId.exists' => 'Selected Job Category is invalid',
            'companyId.required' => 'Company is required',
            'companyId.exists' => 'Selected Company is invalid',
        ];
    }
}
