<?php

namespace App\Http\Requests\GiftCard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGiftCardRequest extends FormRequest
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
            'card_no' => [
                'required',
                'max:255',
                Rule::unique('gift_cards')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'amount'       => ['required', 'numeric', 'min:0'],
            'customer_id'  => ['nullable'],
            'user_id'      => ['nullable'],
            'expired_date' => ['required', 'date'],
        ];
    }
}
