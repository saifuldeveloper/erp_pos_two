<?php

namespace App\Http\Requests\Waste;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWasteRequest extends FormRequest
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
            'warehouse_id'  => ['nullable'],
            'receiver_type' => ['nullable', 'string'],
            'receiver_id'   => ['nullable'],
            'product'       => ['nullable', 'array'],
            'product_id'    => ['nullable', 'array'],
            'qty'           => ['nullable', 'array'],
            'total'         => ['nullable'],
            'total_qty'     => ['nullable'],
            'total_cost'    => ['nullable'],
            'note'          => ['nullable', 'string'],
        ];
    }
}
