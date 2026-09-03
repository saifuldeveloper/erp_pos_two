<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
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
        $accountId = $this->route('account') ?? $this->input('account_id') ?? $this->input('id');

        return [
            'account_no' => [
                'required',
                'max:255',
                Rule::unique('accounts')->ignore($accountId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'name'       => ['required', 'string', 'max:255'],
            'note'       => ['nullable', 'string'],
        ];
    }
}
