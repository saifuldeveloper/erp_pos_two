<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
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
            'sale_id'      => ['nullable'],
            'status'       => ['nullable'],
            'delivered_by' => ['nullable', 'string', 'max:255'],
            'recieved_by'  => ['nullable', 'string', 'max:255'],
            'customer'     => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string'],
            'note'         => ['nullable', 'string'],
            'courier_id'   => ['nullable'],
            'file'         => ['nullable', 'file', 'max:10000'],
        ];
    }
}
