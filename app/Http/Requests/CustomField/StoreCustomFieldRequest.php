<?php

namespace App\Http\Requests\CustomField;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomFieldRequest extends FormRequest
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
            'name'          => ['required', 'string', 'max:255'],
            'belongs_to'    => ['required', 'string'],
            'type'          => ['required', 'string'],
            'default_value' => ['nullable', 'string', 'max:255'],
            'option_value'  => ['nullable', 'string'],
            'grid_value'    => ['nullable', 'numeric', 'min:1', 'max:12'],
            'is_table'      => ['nullable'],
            'is_invoice'    => ['nullable'],
            'is_required'   => ['nullable'],
            'is_admin'      => ['nullable'],
            'is_disable'    => ['nullable'],
        ];
    }
}
