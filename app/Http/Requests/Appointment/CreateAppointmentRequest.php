<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|integer|exists:users,id',
            'appointment_date' => [
                'required',
                'date_format:Y-m-d',
                'after:today'
            ],
            'appointment_time' => 'required|date_format:H:i',
            'remarks' => 'nullable|string|max:1000'

        ];
    }
}
