<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUnitRequest extends FormRequest
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
            'unit_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'unit_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'base_unit'       => ['nullable'],
            'operator'        => ['nullable'],
            'operation_value' => ['nullable'],
        ];
    }
}
