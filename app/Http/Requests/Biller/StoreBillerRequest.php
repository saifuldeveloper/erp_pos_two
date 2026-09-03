<?php

namespace App\Http\Requests\Biller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBillerRequest extends FormRequest
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
            'name'         => ['nullable', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10000'],
            'company_name' => [
                'max:255',
                Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'vat_number'   => ['nullable', 'string', 'max:255'],
            'email'        => [
                'email',
                'max:255',
                Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'state'        => ['nullable', 'string', 'max:255'],
            'postal_code'  => ['nullable', 'string', 'max:255'],
            'country'      => ['nullable', 'string', 'max:255'],
        ];
    }
}
