<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        $courts = [
            [
                'name'           => 'Court Alpha',
                'description'    => 'Professional-grade synthetic court with excellent lighting and ventilation.',
                'location'       => 'Block A, Sports Complex, Main Building',
                'price_per_hour' => 25.00,
                'status'         => 'available',
                'capacity'       => 4,
                'surface_type'   => 'synthetic',
                'amenities'      => ['parking', 'locker', 'shower', 'wifi'],
            ],
            [
                'name'           => 'Court Beta',
                'description'    => 'Wooden-floor court ideal for competitive play with professional net setup.',
                'location'       => 'Block B, Sports Complex, Ground Floor',
                'price_per_hour' => 30.00,
                'status'         => 'available',
                'capacity'       => 4,
                'surface_type'   => 'wood',
                'amenities'      => ['parking', 'locker', 'shower', 'cafeteria'],
            ],
            [
                'name'           => 'Court Gamma',
                'description'    => 'Budget-friendly cement court perfect for casual games and practice.',
                'location'       => 'Block C, Sports Complex, Outdoor Area',
                'price_per_hour' => 15.00,
                'status'         => 'available',
                'capacity'       => 4,
                'surface_type'   => 'cement',
                'amenities'      => ['parking'],
            ],
            [
                'name'           => 'Court Delta',
                'description'    => 'Premium air-conditioned indoor court with tournament-standard flooring.',
                'location'       => 'Block D, Sports Complex, 1st Floor',
                'price_per_hour' => 45.00,
                'status'         => 'available',
                'capacity'       => 4,
                'surface_type'   => 'synthetic',
                'amenities'      => ['parking', 'locker', 'shower', 'wifi', 'cafeteria', 'ac'],
            ],
            [
                'name'           => 'Court Echo',
                'description'    => 'Mid-range synthetic court with natural lighting from skylight windows.',
                'location'       => 'Block A, Sports Complex, 2nd Floor',
                'price_per_hour' => 20.00,
                'status'         => 'available',
                'capacity'       => 4,
                'surface_type'   => 'synthetic',
                'amenities'      => ['parking', 'locker'],
            ],
            [
                'name'           => 'Court Foxtrot',
                'description'    => 'Currently under maintenance for resurfacing. Available soon.',
                'location'       => 'Block E, Sports Complex, Ground Floor',
                'price_per_hour' => 25.00,
                'status'         => 'maintenance',
                'capacity'       => 4,
                'surface_type'   => 'wood',
                'amenities'      => ['parking', 'locker', 'shower'],
            ],
        ];

        foreach ($courts as $court) {
            Court::create($court);
        }
    }
}
