<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransferRequest extends FormRequest
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
            'from_warehouse_id' => ['required'],
            'to_warehouse_id'   => ['required'],
            'status'            => ['nullable'],
            'document'          => ['nullable', 'file', 'max:10000'],
            'shipping_cost'     => ['nullable'],
            'note'              => ['nullable', 'string'],
            'product_id'        => ['nullable', 'array'],
            'qty'               => ['nullable', 'array'],
            'net_unit_cost'     => ['nullable', 'array'],
            'tax_rate'          => ['nullable', 'array'],
            'tax'               => ['nullable', 'array'],
            'subtotal'          => ['nullable', 'array'],
            'total_qty'         => ['nullable'],
            'total_discount'    => ['nullable'],
            'total_tax'         => ['nullable'],
            'total_cost'        => ['nullable'],
            'grand_total'       => ['nullable'],
        ];
    }
}
