<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
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
        if ($this->has('title') && is_string($this->title)) {
            $this->merge([
                'title' => preg_replace('/\s+/', ' ', trim($this->title)),
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
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:100000',
            ],
        ];
    }
}
