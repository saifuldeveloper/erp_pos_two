<?php

namespace App\Http\Requests\ReturnPurchase;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnPurchaseRequest extends FormRequest
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
            'purchase_id'      => ['nullable'],
            'supplier_id'      => ['nullable'],
            'warehouse_id'     => ['nullable'],
            'currency_id'      => ['nullable'],
            'exchange_rate'    => ['nullable'],
            'account_id'       => ['nullable'],
            'document'         => ['nullable', 'file', 'max:10000'],
            'order_tax'        => ['nullable'],
            'order_tax_rate'   => ['nullable'],
            'order_discount'   => ['nullable'],
            'shipping_cost'    => ['nullable'],
            'return_note'      => ['nullable', 'string'],
            'staff_note'       => ['nullable', 'string'],
            'is_return'        => ['nullable', 'array'],
            'product_id'       => ['nullable', 'array'],
            'product_batch_id' => ['nullable', 'array'],
            'qty'              => ['nullable', 'array'],
            'net_unit_cost'    => ['nullable', 'array'],
            'discount'         => ['nullable', 'array'],
            'tax_rate'         => ['nullable', 'array'],
            'tax'              => ['nullable', 'array'],
            'subtotal'         => ['nullable', 'array'],
            'total_qty'        => ['nullable'],
            'total_discount'   => ['nullable'],
            'total_tax'        => ['nullable'],
            'total_cost'       => ['nullable'],
            'grand_total'      => ['nullable'],
        ];
    }
}
