<?php

namespace App\Http\Requests\StockCount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockCountRequest extends FormRequest
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
            'stock_count_id' => ['nullable'],
            'product_id'     => ['nullable', 'array'],
            'counted'        => ['nullable', 'array'],
            'expected'       => ['nullable', 'array'],
            'cost'           => ['nullable', 'array'],
            'action'         => ['nullable'],
        ];
    }
}
