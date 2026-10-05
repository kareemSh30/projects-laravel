<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
            'jobVacancyId' => 'required|uuid|exists:job_vacancies,id',
            'userId' => 'required|uuid|exists:users,id',
            'resumeId' => 'required|uuid|exists:resumes,id',
            'status' => 'required|in:pending,accepted,rejected',
            'aiGeneratedScore' => 'nullable|numeric|min:0|max:100',
            'aiGeneratedFeedback' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'jobVacancyId.required' => 'Job Vacancy is required',
            'jobVacancyId.exists' => 'Selected Job Vacancy does not exist',
            'userId.required' => 'User is required',
            'userId.exists' => 'Selected User does not exist',
            'resumeId.required' => 'Resume is required',
            'resumeId.exists' => 'Selected Resume does not exist',
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status selected',
            'aiGeneratedScore.numeric' => 'AI score must be a number',
            'aiGeneratedScore.min' => 'AI score cannot be negative',
            'aiGeneratedScore.max' => 'AI score cannot exceed 100',
        ];
    }
}
