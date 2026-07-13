@extends('layouts.app')
@section('title', 'My Bookings')
@section('page-title', 'My Bookings')

@section('content')

    <div class="section-heading">
        <h2>Booking History</h2>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">+ New Booking</a>
    </div>

    <div class="card">
        <div class="card-body" style="padding:0;">
            @if($bookings->isEmpty())
                <div style="text-align:center;padding:40px;color:#888;">
                    <p style="font-size:2rem;">&#128197;</p>
                    <p style="margin-top:10px;">You have no bookings yet.</p>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm" style="margin-top:12px;">
                        Book Your First Court
                    </a>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Booking Code</th>
                            <th>Court</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <code style="color:#2c7be5;font-size:12px;">{{ $booking->booking_code }}</code>
                            </td>
                            <td>
                                <strong style="font-size:13px;">{{ $booking->court->name }}</strong><br>
                                <span style="font-size:11px;color:#888;">{{ Str::limit($booking->court->location, 28) }}</span>
                            </td>
                            <td style="font-size:13px;">{{ $booking->booking_date->format('d M Y') }}</td>
                            <td style="font-size:12px;">{{ $booking->timeSlot->label }}</td>
                            <td style="font-weight:bold;color:#28a745;">RM{{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $booking->status_badge }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->payment)
                                    <span class="badge badge-{{ $booking->payment->status_badge }}">
                                        {{ ucfirst($booking->payment->status) }}
                                    </span>
                                @elseif($booking->isPending())
                                    <a href="{{ route('payments.create', $booking) }}"
                                       class="btn btn-success btn-sm">Pay Now</a>
                                @else
                                    <span style="color:#bbb;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="btn btn-outline btn-sm">View</a>

                                    @if($booking->isPending())
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                          onsubmit="return confirm('Cancel this booking?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($bookings->hasPages())
                    <div style="padding:12px;">{{ $bookings->links() }}</div>
                @endif
            @endif
        </div>
    </div>

@endsection
