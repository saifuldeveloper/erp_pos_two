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
            'customer_id'    => ['required'],
            'warehouse_id'   => ['required'],
            'biller_id'      => ['required'],
            'account_id'     => ['nullable'],
            'document'       => ['nullable', 'file', 'max:10000'],
            'order_tax'      => ['nullable'],
            'order_tax_rate' => ['nullable'],
            'order_discount' => ['nullable'],
            'shipping_cost'  => ['nullable'],
            'return_note'    => ['nullable', 'string'],
            'staff_note'     => ['nullable', 'string'],
            'product_id'     => ['required', 'array', 'min:1'],
            'qty'            => ['required', 'array', 'min:1'],
            'net_unit_price' => ['nullable', 'array'],
            'discount'       => ['nullable', 'array'],
            'tax_rate'       => ['nullable', 'array'],
            'tax'            => ['nullable', 'array'],
            'subtotal'       => ['nullable', 'array'],
            'total_qty'      => ['required', 'numeric', 'gt:0'],
            'total_discount' => ['nullable'],
            'total_tax'      => ['nullable'],
            'total_price'    => ['nullable'],
            'grand_total'    => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required'  => 'Customer is required.',
            'warehouse_id.required' => 'Warehouse is required.',
            'biller_id.required'    => 'Biller is required.',
            'product_id.required'   => 'Please select at least one product to return.',
            'product_id.min'        => 'Please select at least one product to return.',
            'qty.required'          => 'Product quantity is required.',
            'total_qty.required'    => 'Total quantity is required.',
            'total_qty.gt'          => 'Total return quantity must be greater than 0.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $qtys = $this->input('qty', []);
            if (is_array($qtys)) {
                foreach ($qtys as $key => $qty) {
                    if ((float)$qty <= 0) {
                        $validator->errors()->add('qty.' . $key, 'Quantity must be greater than 0 for all products.');
                    }
                }
            }
        });
    }
}
