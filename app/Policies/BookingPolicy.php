<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    // Only the booking owner can view it
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    // Only the booking owner can cancel it
    public function cancel(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->isPending();
    }

    // Only the booking owner can pay for it
    public function pay(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->isPending();
    }

    // Only the booking owner can confirm it
    public function confirm(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->isPending();
    }
}
