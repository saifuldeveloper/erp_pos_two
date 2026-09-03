<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'name'              => ['nullable', 'string', 'max:255'],
            'type'              => ['required', 'string'],
            'barcode_symbology' => ['required'],
            'category_id'       => ['required'],
            'brand_id'          => ['nullable'],
            'unit_id'           => ['nullable'],
            'cost'              => ['nullable'],
            'price'             => ['nullable'],
            'image'             => ['nullable'],
            'file'              => ['nullable'],
            'color_images'      => ['nullable'],
        ];
    }
}
