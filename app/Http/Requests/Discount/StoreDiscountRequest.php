<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
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
            'name'              => ['required', 'string', 'max:255'],
            'discount_plan_id'  => ['nullable', 'array'],
            'applicable_for'    => ['required'],
            'product_code'      => ['nullable', 'string'],
            'product_id'        => ['nullable'],
            'valid_from'        => ['required', 'date'],
            'valid_till'        => ['required', 'date'],
            'type'              => ['required'],
            'value'             => ['required', 'numeric'],
            'minimum_qty'       => ['nullable', 'numeric'],
            'maximum_qty'       => ['nullable', 'numeric'],
            'days'              => ['nullable', 'array'],
        ];
    }
}
