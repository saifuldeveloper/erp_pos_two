<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        $customerId = $this->route('customer') ?? $this->input('id') ?? $this->input('customer_id');

        $rules = [
            'phone_number' => [
                'max:255',
                Rule::unique('customers')->ignore($customerId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'customer_group_id' => ['nullable'],
            'name'              => ['nullable', 'string', 'max:255'],
            'company_name'      => ['nullable', 'string', 'max:255'],
            'email'             => ['nullable', 'string', 'max:255'],
            'tax_no'            => ['nullable', 'string', 'max:255'],
            'address'           => ['nullable', 'string', 'max:255'],
            'city'              => ['nullable', 'string', 'max:255'],
            'state'             => ['nullable', 'string', 'max:255'],
            'postal_code'       => ['nullable', 'string', 'max:255'],
            'country'           => ['nullable', 'string', 'max:255'],
        ];

        if ($this->has('user')) {
            $rules['name'] = [
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ];
            $rules['email'] = [
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ];
        }

        return $rules;
    }
}
