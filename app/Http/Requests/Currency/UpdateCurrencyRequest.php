<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
            'currency_id'   => ['nullable'],
            'name'          => ['required', 'string', 'max:255'],
            'code'          => ['required', 'string', 'max:255'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
