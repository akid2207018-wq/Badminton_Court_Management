<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Court;
use App\Models\TimeSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['court', 'timeSlot', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request): View
    {
        $court = null;
        $date  = $request->get('date', now()->format('Y-m-d'));

        if ($request->filled('court_id')) {
            $court = Court::available()->findOrFail($request->court_id);
        }

        $courts    = Court::available()->get();
        $timeSlots = collect();

        if ($court) {
            $timeSlots = TimeSlot::active()->get()->map(function ($slot) use ($court, $date) {
                $slot->booked = $slot->isBooked($court->id, $date);
                return $slot;
            });
        }

        return view('bookings.create', compact('courts', 'court', 'timeSlots', 'date'));
    }

    public function store(BookingRequest $request): RedirectResponse
    {
        $court = Court::available()->findOrFail($request->court_id);

        if (!$court->isAvailable()) {
            return back()->withErrors(['court_id' => 'This court is no longer available.'])->withInput();
        }

        $timeSlot = TimeSlot::active()->findOrFail($request->time_slot_id);

        $booking = DB::transaction(function () use ($court, $timeSlot, $request) {
            $locked = DB::table('bookings')
                ->where('court_id', $court->id)
                ->where('time_slot_id', $timeSlot->id)
                ->where('booking_date', $request->booking_date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->exists();

            if ($locked) {
                return null;
            }

            return Booking::create([
                'booking_code'  => Booking::generateCode(),
                'user_id'       => auth()->id(),
                'court_id'      => $court->id,
                'time_slot_id'  => $timeSlot->id,
                'booking_date'  => $request->booking_date,
                'total_amount'  => $court->price_per_hour,
                'status'        => 'pending',
                'notes'         => $request->notes,
            ]);
        });

        if (!$booking) {
            return back()->withErrors(['time_slot_id' => 'This slot has just been booked. Please choose another.'])->withInput();
        }

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created! Please complete payment to confirm.');
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);
        $booking->load(['court', 'timeSlot', 'payment']);
        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorize('cancel', $booking);

        $booking->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        $this->authorize('confirm', $booking);

        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking confirmed successfully.');
    }

    // AJAX endpoint: get available slots for a court & date
    public function getSlots(Request $request)
    {
        $request->validate([
            'court_id' => ['required', 'integer', 'exists:courts,id'],
            'date'     => ['required', 'date', 'after_or_equal:today'],
        ]);

        $timeSlots = TimeSlot::active()->get()->map(function ($slot) use ($request) {
            return [
                'id'      => $slot->id,
                'label'   => $slot->label,
                'booked'  => $slot->isBooked($request->court_id, $request->date),
            ];
        });

        return response()->json($timeSlots);
    }
}
