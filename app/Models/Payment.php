<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'booking_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'payment_details',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'          => 'decimal:2',
            'payment_details' => 'array',
            'paid_at'         => 'datetime',
        ];
    }

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate unique transaction code
    public static function generateCode(): string
    {
        return 'TXN-' . date('Y') . '-' . strtoupper(Str::random(8));
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'completed' => 'success',
            'failed'    => 'danger',
            'refunded'  => 'info',
            default     => 'secondary',
        };
    }
}
