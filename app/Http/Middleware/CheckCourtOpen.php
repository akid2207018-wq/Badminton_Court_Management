<?php

namespace App\Http\Middleware;

use App\Models\Court;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourtOpen
{
    private const OPEN_HOUR  = 7;
    private const CLOSE_HOUR = 23;

    public function handle(Request $request, Closure $next): Response
    {
        $courtId = $request->input('court_id') ?? $request->route('court');

        if (!$courtId) {
            return $next($request);
        }

        $court = Court::findOrFail($courtId);

        if ($court->status !== 'available') {
            $message = match ($court->status) {
                'maintenance' => 'This court is currently under maintenance and cannot be booked.',
                'closed'      => 'This court is currently closed.',
                default       => 'This court is not available for booking.',
            };
            return back()->withErrors(['court_id' => $message])->withInput();
        }

        $timeSlot = $request->input('time_slot_id')
            ? \App\Models\TimeSlot::find($request->input('time_slot_id'))
            : null;

        if ($timeSlot) {
            $startHour = (int) date('H', strtotime($timeSlot->start_time));
            $endHour   = (int) date('H', strtotime($timeSlot->end_time));

            if ($startHour < self::OPEN_HOUR || $endHour > self::CLOSE_HOUR) {
                return back()->withErrors([
                    'time_slot_id' => 'Bookings are only allowed between '
                        . self::OPEN_HOUR . ':00 and ' . self::CLOSE_HOUR . ':00.',
                ])->withInput();
            }
        }

        return $next($request);
    }
}
