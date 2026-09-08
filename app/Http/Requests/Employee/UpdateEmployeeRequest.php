<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee') ?? $this->input('employee_id') ?? $this->input('id');

        $rules = [
            'name'          => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
            'phone_number'  => ['required', 'string', 'max:255'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:100000'],
            'address'       => ['nullable', 'string'],
            'staff_id'      => ['nullable', 'string', 'max:191'],
            'salary'        => ['nullable', 'numeric', 'min:0'],
            'email'         => ['nullable', 'email', 'max:255'],
            'city'          => ['nullable', 'string'],
            'country'       => ['nullable', 'string'],
        ];

        if ($this->filled('email')) {
            $rules['email'] = [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees')->ignore($employeeId)->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ];
        }

        return $rules;
    }
}
