@extends('layouts.app')
@section('title', $court->name)
@section('page-title', $court->name)

@section('content')

<div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;max-width:900px;">

    <!-- Court Details -->
    <div class="card">
        <!-- Icon Banner -->
        <div style="height:160px;background-color:#e8f0fb;
                    display:flex;align-items:center;justify-content:center;
                    font-size:4rem;border-radius:8px 8px 0 0;">
            &#127992;
        </div>

        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;">
                <div>
                    <h2 style="font-size:1.2rem;color:#1e3a5f;">{{ $court->name }}</h2>
                    <p style="color:#777;font-size:13px;margin-top:3px;">&#128205; {{ $court->location }}</p>
                </div>
                <span class="badge badge-success">Available</span>
            </div>

            <p style="color:#555;font-size:14px;line-height:1.6;margin-bottom:16px;">
                {{ $court->description }}
            </p>

            <!-- Info Table -->
            <table style="margin-bottom:16px;">
                <tbody>
                    <tr>
                        <td style="color:#666;width:140px;padding:8px 0;">Surface Type</td>
                        <td style="font-weight:bold;">{{ ucfirst($court->surface_type) }}</td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:8px 0;">Max Players</td>
                        <td style="font-weight:bold;">{{ $court->capacity }} players</td>
                    </tr>
                    <tr>
                        <td style="color:#666;padding:8px 0;">Price</td>
                        <td style="font-weight:bold;color:#28a745;">RM{{ number_format($court->price_per_hour, 2) }} / hour</td>
                    </tr>
                </tbody>
            </table>

            <!-- Amenities -->
            @if($court->amenities)
            <div>
                <strong style="font-size:13px;color:#444;">Amenities:</strong>
                <div class="tags" style="margin-top:8px;">
                    @foreach($court->amenities as $amenity)
                        <span class="tag">&#10003; {{ ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Booking Panel -->
    <div>
        <div class="card">
            <div class="card-header">Book This Court</div>
            <div class="card-body" style="text-align:center;">
                <div style="font-size:2rem;font-weight:bold;color:#28a745;margin-bottom:4px;">
                    RM{{ number_format($court->price_per_hour, 2) }}
                </div>
                <div style="font-size:12px;color:#888;margin-bottom:20px;">per hour</div>

                @auth
                    <a href="{{ route('bookings.create', ['court_id' => $court->id]) }}"
                       class="btn btn-primary" style="width:100%;display:block;padding:12px;">
                        Book Now
                    </a>
                @else
                    <p style="font-size:13px;color:#888;margin-bottom:12px;">Login to book this court.</p>
                    <a href="{{ route('login') }}"
                       class="btn btn-primary" style="width:100%;display:block;padding:12px;">
                        Login to Book
                    </a>
                @endauth

                <div class="info-box" style="margin-top:16px;text-align:left;">
                    <strong style="font-size:12px;display:block;margin-bottom:6px;">Operating Hours</strong>
                    <div style="font-size:13px;">&#128336; 07:00 AM &mdash; 10:00 PM</div>
                    <div style="font-size:13px;margin-top:4px;">&#128197; Monday &mdash; Sunday</div>
                </div>
            </div>
        </div>

        <div style="margin-top:12px;">
            <a href="{{ route('courts.index') }}" class="btn btn-secondary btn-sm">
                &larr; Back to Courts
            </a>
        </div>
    </div>

</div>

@endsection
