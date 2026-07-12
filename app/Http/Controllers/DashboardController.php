<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'total_bookings'     => Booking::where('user_id', $user->id)->count(),
            'confirmed_bookings' => Booking::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'pending_bookings'   => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'cancelled_bookings' => Booking::where('user_id', $user->id)->where('status', 'cancelled')->count(),
        ];

        $recentBookings = Booking::with(['court', 'timeSlot'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $availableCourts = Court::available()->take(4)->get();

        return view('dashboard', compact('stats', 'recentBookings', 'availableCourts'));
    }
}
