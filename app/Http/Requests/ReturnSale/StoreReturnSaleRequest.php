<?php

namespace App\Http\Requests\ReturnSale;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnSaleRequest extends FormRequest
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
            'sale_id'          => ['required'],
            'customer_id'      => ['required'],
            'warehouse_id'     => ['required'],
            'biller_id'        => ['required'],
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
            'is_return'        => ['required', 'array', 'min:1'],
            'product_id'       => ['required', 'array', 'min:1'],
            'product_batch_id' => ['nullable', 'array'],
            'qty'              => ['required', 'array', 'min:1'],
            'net_unit_price'   => ['nullable', 'array'],
            'discount'         => ['nullable', 'array'],
            'tax_rate'         => ['nullable', 'array'],
            'tax'              => ['nullable', 'array'],
            'subtotal'         => ['nullable', 'array'],
            'total_qty'        => ['required', 'numeric', 'gt:0'],
            'total_discount'   => ['nullable'],
            'total_tax'        => ['nullable'],
            'total_price'      => ['nullable'],
            'grand_total'      => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'sale_id.required'     => 'Sale reference is required.',
            'customer_id.required' => 'Customer is required.',
            'warehouse_id.required'=> 'Warehouse is required.',
            'biller_id.required'   => 'Biller is required.',
            'is_return.required'   => 'Please select at least one product to return.',
            'is_return.min'        => 'Please select at least one product to return.',
            'product_id.required'  => 'Please select products to return.',
            'qty.required'         => 'Quantity is required.',
            'total_qty.required'   => 'Total quantity is required.',
            'total_qty.gt'         => 'Total return quantity must be greater than 0.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isReturn = $this->input('is_return', []);
            $qtys = $this->input('qty', []);
            $actualQtys = $this->input('actual_qty', []);

            if (empty($isReturn) || !is_array($isReturn)) {
                return;
            }

            foreach (array_keys($isReturn) as $key) {
                $qty = isset($qtys[$key]) ? (float)$qtys[$key] : 0;
                $actualQty = isset($actualQtys[$key]) ? (float)$actualQtys[$key] : null;

                if ($qty <= 0) {
                    $validator->errors()->add('qty.' . $key, 'Return quantity must be greater than 0 for selected products.');
                }

                if ($actualQty !== null && $qty > $actualQty) {
                    $validator->errors()->add('qty.' . $key, 'Return quantity cannot be bigger than the actual quantity.');
                }
            }
        });
    }
}
