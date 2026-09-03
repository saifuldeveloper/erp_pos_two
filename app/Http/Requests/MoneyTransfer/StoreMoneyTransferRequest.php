<?php

namespace App\Http\Requests\MoneyTransfer;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoneyTransferRequest extends FormRequest
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
            'from_account_id' => ['required'],
            'to_account_id'   => ['required', 'different:from_account_id'],
            'amount'          => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
