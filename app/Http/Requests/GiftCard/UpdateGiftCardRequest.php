<?php

namespace App\Http\Requests\GiftCard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGiftCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $mergeData = [];

        if ($this->has('card_no_edit')) {
            $mergeData['card_no'] = $this->input('card_no_edit');
        }
        if ($this->has('amount_edit')) {
            $mergeData['amount'] = $this->input('amount_edit');
        }
        if ($this->has('expired_date_edit')) {
            $mergeData['expired_date'] = $this->input('expired_date_edit');
        }
        if ($this->input('user_edit')) {
            $mergeData['user_id'] = $this->input('user_id_edit');
            $mergeData['customer_id'] = null;
        } elseif ($this->has('customer_id_edit')) {
            $mergeData['customer_id'] = $this->input('customer_id_edit');
            $mergeData['user_id'] = null;
        }

        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cardId = $this->route('gift_card') ?? $this->input('gift_card_id') ?? $this->input('id');

        return [
            'card_no' => [
                'required',
                'max:255',
                Rule::unique('gift_cards')->ignore($cardId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'amount'       => ['required', 'numeric', 'min:0'],
            'customer_id'  => ['nullable'],
            'user_id'      => ['nullable'],
            'expired_date' => ['nullable', 'date'],
        ];
    }
}
