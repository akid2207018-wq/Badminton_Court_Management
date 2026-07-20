<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        if ($this->card_number) {
            $this->merge([
                'card_number' => preg_replace('/\s/', '', $this->card_number),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'booking_id'     => ['required', 'integer', 'exists:bookings,id'],
            'payment_method' => ['required', 'string', 'in:credit_card,debit_card,bank_transfer,e_wallet'],
            // Simulated card fields (only validated when credit/debit card)
            'card_number'    => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'digits:16'],
            'card_holder'    => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'string', 'max:100'],
            'expiry_month'   => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'integer', 'between:1,12'],
            'expiry_year'    => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'integer', 'min:' . date('Y')],
            'cvv'            => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'digits_between:3,4'],
        ];
    }

    public function messages(): array
    {
        return [
            'card_number.digits'  => 'Card number must be exactly 16 digits.',
            'cvv.digits_between'  => 'CVV must be 3 or 4 digits.',
        ];
    }
}
