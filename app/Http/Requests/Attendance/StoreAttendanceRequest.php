<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
            'date'        => ['required', 'date'],
            'employee_id' => ['required', 'array'],
            'checkin'     => ['nullable', 'array'],
            'checkout'    => ['nullable', 'array'],
            'status'      => ['nullable', 'array'],
            'note'        => ['nullable', 'array'],
        ];
    }
}
