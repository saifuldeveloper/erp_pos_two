<?php

namespace App\Http\Requests\PayrollType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePayrollTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name') && !$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:255', 'unique:payroll_types,name'],
            'slug'   => ['required', 'string', 'max:255', 'unique:payroll_types,slug'],
            'status' => ['required', 'in:Active,Inactive'],
        ];
    }
}
