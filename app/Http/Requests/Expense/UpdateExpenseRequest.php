<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'expense_id'          => ['nullable'],
            'expense_category_id' => ['required'],
            'warehouse_id'        => ['required'],
            'amount'              => ['required', 'numeric'],
            'account_id'          => ['nullable'],
            'note'                => ['nullable', 'string'],
        ];
    }
}
