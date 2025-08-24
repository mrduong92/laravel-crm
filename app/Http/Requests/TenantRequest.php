<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
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
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'domain' => [
                'required',
                'string',
                'max:255',
            ],
        ];
        if ($this->isMethod('POST')) {
            $rules['id'] = [
                'required',
                'string',
                'max:255',
                'unique:tenants,id,' . $this->route('id')
            ];
        } else {
            $rules['id'] = [
                'nullable',
                'string',
                'max:255',
            ];
        }
        return $rules;
    }
}
