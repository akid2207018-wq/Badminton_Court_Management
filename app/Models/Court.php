<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'price_per_hour',
        'status',
        'capacity',
        'surface_type',
        'amenities',
    ];

    protected function casts(): array
    {
        return [
            'amenities'      => 'array',
            'price_per_hour' => 'decimal:2',
        ];
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
