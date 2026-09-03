<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->input('id') ?? $this->input('product_id');

        return [
            'id' => ['nullable'],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'name'              => ['nullable', 'string', 'max:255'],
            'type'              => ['nullable', 'string'],
            'barcode_symbology' => ['nullable'],
            'category_id'       => ['nullable'],
            'brand_id'          => ['nullable'],
            'unit_id'           => ['nullable'],
            'cost'              => ['nullable'],
            'price'             => ['nullable'],
            'image'             => ['nullable'],
            'file'              => ['nullable'],
            'prev_img'          => ['nullable'],
            'color_images'      => ['nullable'],
        ];
    }
}
