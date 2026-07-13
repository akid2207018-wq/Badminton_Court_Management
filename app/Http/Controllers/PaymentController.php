<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['booking.court'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(Booking $booking): View
    {
        $this->authorize('pay', $booking);
        $booking->load(['court', 'timeSlot']);
        return view('payments.process', compact('booking'));
    }

    public function store(PaymentRequest $request): RedirectResponse
    {
        $booking = Booking::findOrFail($request->booking_id);
        $this->authorize('pay', $booking);

        // Simulate payment processing (always succeeds in simulation)
        $maskedDetails = $this->buildPaymentDetails($request);

        $payment = Payment::create([
            'transaction_code' => Payment::generateCode(),
            'booking_id'       => $booking->id,
            'user_id'          => auth()->id(),
            'amount'           => $booking->total_amount,
            'payment_method'   => $request->payment_method,
            'status'           => 'completed',
            'payment_details'  => $maskedDetails,
            'paid_at'          => now(),
        ]);

        // Confirm the booking
        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Payment successful! Your booking is confirmed. Transaction: ' . $payment->transaction_code);
    }

    private function buildPaymentDetails(PaymentRequest $request): array
    {
        if (in_array($request->payment_method, ['credit_card', 'debit_card'])) {
            return [
                'card_holder' => $request->card_holder,
                'card_last4'  => substr($request->card_number, -4),
                'expiry'      => $request->expiry_month . '/' . $request->expiry_year,
            ];
        }

        return ['method' => $request->payment_method];
    }
}
