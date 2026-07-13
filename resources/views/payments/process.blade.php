@extends('layouts.app')
@section('title', 'Make Payment')
@section('page-title', 'Payment')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:18px;max-width:860px;">

    <!-- Payment Form -->
    <div class="card">
        <div class="card-header">&#128179; Payment Details</div>
        <div class="card-body">

            <form method="POST" action="{{ route('payments.store') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <!-- Payment Method -->
                <div class="form-group">
                    <label>Choose Payment Method</label>
                    <div class="method-options">
                        @foreach([
                            'credit_card'   => ['Credit Card',   '&#128179;'],
                            'debit_card'    => ['Debit Card',    '&#128180;'],
                            'bank_transfer' => ['Bank Transfer', '&#127981;'],
                            'e_wallet'      => ['E-Wallet',      '&#128241;'],
                        ] as $value => [$label, $icon])
                        <div class="method-option">
                            <input type="radio" name="payment_method"
                                   id="method_{{ $value }}"
                                   value="{{ $value }}"
                                   {{ old('payment_method', 'credit_card') === $value ? 'checked' : '' }}>
                            <label for="method_{{ $value }}">
                                <span class="method-icon">{!! $icon !!}</span>
                                {{ $label }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('payment_method')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Card Fields -->
                <div id="cardFields">
                    <hr style="border:none;border-top:1px solid #eee;margin:16px 0;">

                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number"
                               placeholder="1234 5678 9012 3456"
                               maxlength="19"
                               value="{{ old('card_number') }}"
                               class="{{ $errors->has('card_number') ? 'is-invalid' : '' }}">
                        @error('card_number')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="card_holder">Cardholder Name</label>
                        <input type="text" id="card_holder" name="card_holder"
                               placeholder="Name as printed on card"
                               value="{{ old('card_holder') }}"
                               class="{{ $errors->has('card_holder') ? 'is-invalid' : '' }}">
                        @error('card_holder')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                        <div class="form-group">
                            <label for="expiry_month">Expiry Month</label>
                            <select id="expiry_month" name="expiry_month"
                                    class="{{ $errors->has('expiry_month') ? 'is-invalid' : '' }}">
                                <option value="">MM</option>
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ old('expiry_month') == $m ? 'selected' : '' }}>
                                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                                    </option>
                                @endfor
                            </select>
                            @error('expiry_month')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expiry_year">Expiry Year</label>
                            <select id="expiry_year" name="expiry_year"
                                    class="{{ $errors->has('expiry_year') ? 'is-invalid' : '' }}">
                                <option value="">YYYY</option>
                                @for($y = date('Y'); $y <= date('Y') + 10; $y++)
                                    <option value="{{ $y }}" {{ old('expiry_year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            @error('expiry_year')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv"
                                   placeholder="123"
                                   maxlength="4"
                                   value="{{ old('cvv') }}"
                                   class="{{ $errors->has('cvv') ? 'is-invalid' : '' }}">
                            @error('cvv')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Non-card notice -->
                <div id="nonCardNote" style="display:none;">
                    <div class="info-box" style="margin-top:8px;">
                        &#8505; This is a simulated payment. Click the button below to complete your booking.
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <button type="submit" class="btn btn-success" style="padding:12px 28px;font-size:15px;">
                        &#128274; Pay RM{{ number_format($booking->total_amount, 2) }}
                    </button>
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-secondary" style="margin-left:8px;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Order Summary -->
    <div>
        <div class="card">
            <div class="card-header">&#128203; Order Summary</div>
            <div class="card-body">
                <table style="font-size:14px;">
                    <tbody>
                        <tr>
                            <td style="color:#666;padding:7px 0;">Court</td>
                            <td style="font-weight:bold;text-align:right;">{{ $booking->court->name }}</td>
                        </tr>
                        <tr>
                            <td style="color:#666;padding:7px 0;">Date</td>
                            <td style="text-align:right;">{{ $booking->booking_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="color:#666;padding:7px 0;">Time</td>
                            <td style="text-align:right;font-size:12px;">{{ $booking->timeSlot->label }}</td>
                        </tr>
                        <tr>
                            <td style="color:#666;padding:7px 0;">Booking Code</td>
                            <td style="text-align:right;">
                                <code style="color:#2c7be5;font-size:12px;">{{ $booking->booking_code }}</code>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr style="border:none;border-top:1px solid #eee;margin:12px 0;">

                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <strong>Total Due</strong>
                    <strong style="font-size:1.3rem;color:#28a745;">
                        RM{{ number_format($booking->total_amount, 2) }}
                    </strong>
                </div>

                <div class="info-box" style="margin-top:14px;font-size:12px;text-align:center;">
                    &#128274; Secure Simulated Payment
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Card number formatting
document.getElementById('card_number').addEventListener('input', function(e) {
    let val = e.target.value.replace(/\D/g, '').substring(0, 16);
    e.target.value = val.replace(/(.{4})/g, '$1 ').trim();
});

// Toggle card vs non-card fields
const radios = document.querySelectorAll('input[name="payment_method"]');
const cardFields = document.getElementById('cardFields');
const nonCardNote = document.getElementById('nonCardNote');

function updateUI() {
    const method = document.querySelector('input[name="payment_method"]:checked')?.value;
    const isCard = (method === 'credit_card' || method === 'debit_card');
    cardFields.style.display  = isCard ? 'block' : 'none';
    nonCardNote.style.display = isCard ? 'none'  : 'block';
}

radios.forEach(r => r.addEventListener('change', updateUI));
updateUI(); // run on load
</script>

@endsection
