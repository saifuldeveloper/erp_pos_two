<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('role') ?? $this->input('role_id') ?? $this->input('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('roles')->ignore($roleId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
