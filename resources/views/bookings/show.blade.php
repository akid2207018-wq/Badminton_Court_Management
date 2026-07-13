@extends('layouts.app')
@section('title', 'Booking ' . $booking->booking_code)
@section('page-title', 'Booking Details')

@section('content')

<div style="max-width:680px;">

    <!-- Status Banner -->
    @if($booking->isConfirmed())
        <div class="info-box success" style="margin-bottom:18px;display:flex;align-items:center;gap:10px;">
            <span style="font-size:1.4rem;">&#10004;</span>
            <div>
                <strong>Booking Confirmed!</strong><br>
                <span style="font-size:13px;">Confirmed on {{ $booking->confirmed_at?->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    @elseif($booking->isPending())
        <div class="info-box warning" style="margin-bottom:18px;display:flex;align-items:center;gap:10px;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:1.4rem;">&#9201;</span>
                <div>
                    <strong>Payment Pending</strong><br>
                    <span style="font-size:13px;">Complete payment to confirm your booking.</span>
                </div>
            </div>
            <a href="{{ route('payments.create', $booking) }}" class="btn btn-success btn-sm">Pay Now</a>
        </div>
    @elseif($booking->isCancelled())
        <div class="info-box danger" style="margin-bottom:18px;display:flex;align-items:center;gap:10px;">
            <span style="font-size:1.4rem;">&#10008;</span>
            <div>
                <strong>Booking Cancelled</strong><br>
                <span style="font-size:13px;">Cancelled on {{ $booking->cancelled_at?->format('d M Y, h:i A') }}</span>
            </div>
        </div>
    @endif

    <!-- Booking Details -->
    <div class="card">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <span>&#127915; Booking Details</span>
            <span class="badge badge-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
        </div>
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td style="color:#666;width:160px;padding:9px 0;">Booking Code</td>
                        <td><code style="color:#2c7be5;font-size:14px;font-weight:bold;">{{ $booking->booking_code }}</code></td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:9px 0;">Court</td>
                        <td>
                            <strong>{{ $booking->court->name }}</strong><br>
                            <span style="font-size:12px;color:#888;">{{ $booking->court->location }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:9px 0;">Date</td>
                        <td><strong>{{ $booking->booking_date->format('l, d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:9px 0;">Time Slot</td>
                        <td><strong>{{ $booking->timeSlot->label }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:9px 0;">Total Amount</td>
                        <td><strong style="color:#28a745;font-size:1.1rem;">RM{{ number_format($booking->total_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:9px 0;">Booked On</td>
                        <td>{{ $booking->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @if($booking->notes)
                    <tr>
                        <td style="color:#666;padding:9px 0;">Notes</td>
                        <td style="font-style:italic;">{{ $booking->notes }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Info -->
    @if($booking->payment)
    <div class="card">
        <div class="card-header">&#128179; Payment Information</div>
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td style="color:#666;width:160px;padding:8px 0;">Transaction Code</td>
                        <td><code style="color:#28a745;font-weight:bold;">{{ $booking->payment->transaction_code }}</code></td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:8px 0;">Payment Method</td>
                        <td>{{ ucwords(str_replace('_', ' ', $booking->payment->payment_method)) }}</td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:8px 0;">Amount Paid</td>
                        <td style="font-weight:bold;color:#28a745;">RM{{ number_format($booking->payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:8px 0;">Paid At</td>
                        <td>{{ $booking->payment->paid_at?->format('d M Y, h:i A') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div style="display:flex;gap:10px;margin-top:6px;">
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">&larr; Back to Bookings</a>

        @if($booking->isPending())
            <a href="{{ route('payments.create', $booking) }}" class="btn btn-success">Pay Now</a>

            <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">Cancel Booking</button>
            </form>
        @endif
    </div>

</div>

@endsection
