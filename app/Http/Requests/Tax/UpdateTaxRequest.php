<?php

namespace App\Http\Requests\Tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaxRequest extends FormRequest
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
        $taxId = $this->route('tax') ?? $this->input('tax_id') ?? $this->input('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('taxes')->ignore($taxId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
