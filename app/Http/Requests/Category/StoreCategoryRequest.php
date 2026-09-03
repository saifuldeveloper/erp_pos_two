<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
        if ($this->has('name') && is_string($this->name)) {
            $this->merge([
                'name' => preg_replace('/\s+/', ' ', trim($this->name)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('is_active', 1)
                        ->where('parent_id', $this->parent_id);
                }),
            ],
            'parent_id' => ['nullable'],
            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif'],
            'icon'      => ['nullable', 'mimetypes:text/plain,image/png,image/jpeg,image/svg'],
        ];
    }
}
