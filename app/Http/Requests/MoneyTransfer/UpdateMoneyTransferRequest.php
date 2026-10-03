<?php

namespace App\Http\Requests\MoneyTransfer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMoneyTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return false;
        }
        if ($user->role_id <= 2) {
            return true;
        }
        $role = \Spatie\Permission\Models\Role::find($user->role_id);
        return $role ? $role->hasPermissionTo('money-transfer-edit') : false;
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
