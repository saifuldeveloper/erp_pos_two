<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier') ?? $this->input('id') ?? $this->input('supplier_id');

        $rules = [
            'name'         => ['required', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:100000'],
            'company_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers')->ignore($supplierId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'vat_number'   => ['nullable', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address'      => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'state'        => ['nullable', 'string', 'max:255'],
            'postal_code'  => ['nullable', 'string', 'max:255'],
            'country'      => ['nullable', 'string', 'max:255'],
        ];

        if ($this->filled('email')) {
            $rules['email'] = [
                'nullable',
                'email',
                'max:255',
                Rule::unique('suppliers')->ignore($supplierId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ];
        }

        return $rules;
    }
}
