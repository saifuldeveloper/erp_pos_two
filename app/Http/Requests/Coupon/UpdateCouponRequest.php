<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'coupon_id'    => ['nullable'],
            'code'         => ['required', 'string', 'max:255'],
            'type'         => ['required', 'string'],
            'amount'       => ['required', 'numeric'],
            'minimum_amount' => ['nullable', 'numeric'],
            'quantity'     => ['required', 'integer'],
            'expired_date' => ['required', 'date'],
        ];
    }
}
