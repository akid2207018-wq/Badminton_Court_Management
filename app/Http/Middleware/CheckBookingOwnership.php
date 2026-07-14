<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $booking = $request->route('booking');

        if (!$booking instanceof Booking) {
            $bookingId = $request->route('booking');
            $booking = Booking::findOrFail($bookingId);
        }

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'You do not have access to this booking.');
        }

        $request->attributes->set('booking', $booking);

        return $next($request);
    }
}
