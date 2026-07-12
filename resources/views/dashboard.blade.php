@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#28a745;">{{ $stats['confirmed_bookings'] }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#e6a817;">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#dc3545;">{{ $stats['cancelled_bookings'] }}</div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;">

        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header">
                <div class="section-heading" style="margin:0;">
                    <span>&#128197; Recent Bookings</span>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                @if($recentBookings->isEmpty())
                    <div style="text-align:center;padding:36px;color:#888;">
                        <p>No bookings yet.</p>
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm" style="margin-top:8px;">
                            Book Your First Court
                        </a>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Court</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr>
                                <td><code style="color:#2c7be5;font-size:12px;">{{ $booking->booking_code }}</code></td>
                                <td>{{ $booking->court->name }}</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                <td style="font-size:13px;">{{ $booking->timeSlot->label }}</td>
                                <td>
                                    <span class="badge badge-{{ $booking->status_badge }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="btn btn-outline btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Available Courts Quick View -->
        <div class="card">
            <div class="card-header">
                <div class="section-heading" style="margin:0;">
                    <span>&#127968; Courts</span>
                    <a href="{{ route('courts.index') }}" class="btn btn-outline btn-sm">Browse</a>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                @foreach($availableCourts as $court)
                <div style="padding:12px 16px;border-bottom:1px solid #f0f2f5;">
                    <div style="font-weight:bold;font-size:14px;">{{ $court->name }}</div>
                    <div style="font-size:12px;color:#777;margin:2px 0;">{{ Str::limit($court->location, 35) }}</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                        <span class="court-price" style="font-size:14px;">RM{{ number_format($court->price_per_hour, 2) }}/hr</span>
                        <a href="{{ route('bookings.create', ['court_id' => $court->id]) }}"
                           class="btn btn-primary btn-sm">Book</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection
