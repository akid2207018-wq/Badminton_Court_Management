<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        // Operating hours: 07:00 - 22:00, 1-hour slots
        $slots = [
            ['start_time' => '07:00:00', 'end_time' => '08:00:00', 'label' => '07:00 AM - 08:00 AM'],
            ['start_time' => '08:00:00', 'end_time' => '09:00:00', 'label' => '08:00 AM - 09:00 AM'],
            ['start_time' => '09:00:00', 'end_time' => '10:00:00', 'label' => '09:00 AM - 10:00 AM'],
            ['start_time' => '10:00:00', 'end_time' => '11:00:00', 'label' => '10:00 AM - 11:00 AM'],
            ['start_time' => '11:00:00', 'end_time' => '12:00:00', 'label' => '11:00 AM - 12:00 PM'],
            ['start_time' => '12:00:00', 'end_time' => '13:00:00', 'label' => '12:00 PM - 01:00 PM'],
            ['start_time' => '13:00:00', 'end_time' => '14:00:00', 'label' => '01:00 PM - 02:00 PM'],
            ['start_time' => '14:00:00', 'end_time' => '15:00:00', 'label' => '02:00 PM - 03:00 PM'],
            ['start_time' => '15:00:00', 'end_time' => '16:00:00', 'label' => '03:00 PM - 04:00 PM'],
            ['start_time' => '16:00:00', 'end_time' => '17:00:00', 'label' => '04:00 PM - 05:00 PM'],
            ['start_time' => '17:00:00', 'end_time' => '18:00:00', 'label' => '05:00 PM - 06:00 PM'],
            ['start_time' => '18:00:00', 'end_time' => '19:00:00', 'label' => '06:00 PM - 07:00 PM'],
            ['start_time' => '19:00:00', 'end_time' => '20:00:00', 'label' => '07:00 PM - 08:00 PM'],
            ['start_time' => '20:00:00', 'end_time' => '21:00:00', 'label' => '08:00 PM - 09:00 PM'],
            ['start_time' => '21:00:00', 'end_time' => '22:00:00', 'label' => '09:00 PM - 10:00 PM'],
        ];

        foreach ($slots as $slot) {
            TimeSlot::create(array_merge($slot, ['is_active' => true]));
        }
    }
}
