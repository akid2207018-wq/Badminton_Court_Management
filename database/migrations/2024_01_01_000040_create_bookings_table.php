<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 20)->unique(); // BCK-2024-0001
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
            $table->foreignId('time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->date('booking_date');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Composite unique: one booking per court/slot/date
            $table->unique(['court_id', 'time_slot_id', 'booking_date'], 'unique_court_slot_date');

            // Indexes
            $table->index('booking_date');
            $table->index('status');
            $table->index('user_id');
            $table->index('court_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
