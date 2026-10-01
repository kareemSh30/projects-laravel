<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobCategoryUpdateRequest extends FormRequest
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
            'name'=>'required|string|max:255|unique:job_categories,name,' . $this->route()->parameter('job_category')
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Name is required',
            'name.unique'=>'Name is already taken',
            'name.max'=>'Name cannot exceed 255 characters',
            'name.string'=>'Name must be a characters'
        ];
    }

   
}
