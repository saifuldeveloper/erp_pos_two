<?php

namespace App\Http\Requests\DiscountPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role_id <= 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'customer_id' => ['nullable', 'array'],
        ];
    }
}
