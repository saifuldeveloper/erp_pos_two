<?php

namespace App\Http\Requests\Adjustment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdjustmentRequest extends FormRequest
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
            'warehouse_id' => ['required'],
            'document'     => ['nullable', 'file', 'max:10000'],
            'product_id'   => ['nullable', 'array'],
            'qty'          => ['nullable', 'array'],
            'action'       => ['nullable', 'array'],
            'total_qty'    => ['nullable'],
            'item'         => ['nullable'],
            'note'         => ['nullable', 'string'],
        ];
    }
}
