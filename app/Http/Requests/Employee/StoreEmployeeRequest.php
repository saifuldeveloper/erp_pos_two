<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'phone_number'  => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:100000'],
            'address'       => ['nullable', 'string'],
            'city'          => ['nullable', 'string'],
            'country'       => ['nullable', 'string'],
            'user'          => ['nullable'],
        ];

        if ($this->has('user')) {
            $rules['user_name'] = [
                'nullable',
                'max:255',
                Rule::unique('users', 'name')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ];
            $rules['user_email'] = [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ];
            // Also if request passes name / email directly for user
            $rules['name'] = [
                'required',
                'max:255',
                Rule::unique('users', 'name')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ];
        }

        return $rules;
    }
}
