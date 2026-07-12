@extends('layouts.app')
@section('title', 'Payment History')
@section('page-title', 'Payment History')

@section('content')

    <div class="section-heading">
        <h2>Payment History</h2>
    </div>

    <div class="card">
        <div class="card-body" style="padding:0;">
            @if($payments->isEmpty())
                <div style="text-align:center;padding:40px;color:#888;">
                    <p style="font-size:2rem;">&#128179;</p>
                    <p style="margin-top:10px;">No payment records found.</p>
                    <a href="{{ route('courts.index') }}" class="btn btn-primary btn-sm" style="margin-top:12px;">
                        Browse Courts
                    </a>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Transaction Code</th>
                            <th>Booking</th>
                            <th>Court</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                <code style="color:#28a745;font-size:12px;">{{ $payment->transaction_code }}</code>
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $payment->booking) }}"
                                   style="font-size:13px;color:#2c7be5;">
                                    {{ $payment->booking->booking_code }}
                                </a>
                            </td>
                            <td style="font-size:13px;">{{ $payment->booking->court->name }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </td>
                            <td style="font-weight:bold;color:#28a745;">
                                RM{{ number_format($payment->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $payment->status_badge }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td style="font-size:13px;">
                                {{ $payment->paid_at?->format('d M Y, h:i A') ?? '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($payments->hasPages())
                    <div style="padding:12px;">{{ $payments->links() }}</div>
                @endif
            @endif
        </div>
    </div>

@endsection
