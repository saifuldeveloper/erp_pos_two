<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayrollRequest extends FormRequest
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
            'payroll_id'    => ['nullable'],
            'employee_id'   => ['required'],
            'account_id'    => ['required'],
            'amount'        => ['required', 'numeric', 'min:0'],
            'paying_method' => ['required'],
            'note'          => ['nullable', 'string'],
        ];
    }
}
