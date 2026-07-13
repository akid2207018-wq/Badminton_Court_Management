<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'label',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check if this slot is booked for a given court & date
    public function isBooked(int $courtId, string $date): bool
    {
        return $this->bookings()
            ->where('court_id', $courtId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }
}
