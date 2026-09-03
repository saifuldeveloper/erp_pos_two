<?php

namespace App\Http\Requests\ExpenseCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseCategoryRequest extends FormRequest
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
        $catId = $this->route('expense_category') ?? $this->input('expense_category_id') ?? $this->input('id');

        return [
            'code' => [
                'required',
                'max:255',
                Rule::unique('expense_categories')->ignore($catId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
