<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('location', 200);
            $table->decimal('price_per_hour', 8, 2);
            $table->enum('status', ['available', 'maintenance', 'closed'])->default('available');
            $table->unsignedTinyInteger('capacity')->default(4);
            $table->string('surface_type', 50)->default('synthetic');
            $table->json('amenities')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('price_per_hour');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
