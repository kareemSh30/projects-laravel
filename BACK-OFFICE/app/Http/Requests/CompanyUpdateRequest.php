<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
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
        $companyId = $this->route('company');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('companies', 'name')->ignore($companyId),
            ],
            'address' => 'nullable|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|max:100|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name already exists',
            'address.required' => 'Address is required',
            'industry.required' => 'Industry is required',
            'website.url' => 'Website is invalid',
            'website.max' => 'Website is too long',
        ];
    }
}
