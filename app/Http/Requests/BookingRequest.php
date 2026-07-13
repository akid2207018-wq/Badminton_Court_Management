<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'court_id'     => ['required', 'integer', 'exists:courts,id'],
            'time_slot_id' => ['required', 'integer', 'exists:time_slots,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'booking_date.after_or_equal' => 'Booking date must be today or a future date.',
            'court_id.exists'             => 'Selected court does not exist.',
            'time_slot_id.exists'         => 'Selected time slot does not exist.',
        ];
    }
}
