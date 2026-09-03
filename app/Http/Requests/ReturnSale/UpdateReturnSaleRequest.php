<?php

namespace App\Http\Requests\ReturnSale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReturnSaleRequest extends FormRequest
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
            'customer_id'    => ['nullable'],
            'warehouse_id'   => ['nullable'],
            'biller_id'      => ['nullable'],
            'account_id'     => ['nullable'],
            'document'       => ['nullable', 'file', 'max:10000'],
            'order_tax'      => ['nullable'],
            'order_tax_rate' => ['nullable'],
            'order_discount' => ['nullable'],
            'shipping_cost'  => ['nullable'],
            'return_note'    => ['nullable', 'string'],
            'staff_note'     => ['nullable', 'string'],
            'product_id'     => ['nullable', 'array'],
            'qty'            => ['nullable', 'array'],
            'net_unit_price' => ['nullable', 'array'],
            'discount'       => ['nullable', 'array'],
            'tax_rate'       => ['nullable', 'array'],
            'tax'            => ['nullable', 'array'],
            'subtotal'       => ['nullable', 'array'],
            'total_qty'      => ['nullable'],
            'total_discount' => ['nullable'],
            'total_tax'      => ['nullable'],
            'total_price'        => ['nullable'],
            'grand_total'    => ['nullable'],
        ];
    }
}
