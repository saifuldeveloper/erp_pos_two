<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateColorRequest extends FormRequest
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
            'color_id' => ['required'],
            'name'     => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors', 'name')->ignore($this->color_id),
            ],
            'code'     => ['nullable', 'string', 'max:255'],
        ];
    }
}
