<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user') ?? $this->route('id') ?? $this->input('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($userId)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'role_id'      => ['nullable'],
            'phone'        => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'biller_id'    => ['nullable'],
            'warehouse_id' => ['nullable'],
            'customer_id'  => ['nullable'],
        ];
    }
}
