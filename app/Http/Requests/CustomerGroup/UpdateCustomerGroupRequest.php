<?php

namespace App\Http\Requests\CustomerGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerGroupRequest extends FormRequest
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
        $groupId = $this->route('customer_group') ?? $this->input('customer_group_id') ?? $this->input('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('customer_groups')->ignore($groupId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'percentage' => ['required', 'numeric'],
        ];
    }
}
