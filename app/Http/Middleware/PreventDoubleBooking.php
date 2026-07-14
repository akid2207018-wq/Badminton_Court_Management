<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'court_id'     => ['required', 'integer', 'exists:courts,id'],
            'time_slot_id' => ['required', 'integer', 'exists:time_slots,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $exists = Booking::where('court_id', $request->court_id)
            ->where('time_slot_id', $request->time_slot_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'time_slot_id' => 'This time slot is already booked for the selected date. Please choose another.',
            ])->withInput();
        }

        return $next($request);
    }
}
