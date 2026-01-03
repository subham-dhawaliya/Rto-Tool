<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('booking_number')->unique();
            $table->string('service_type');
            $table->string('application_number')->nullable();
            $table->string('rto_office');
            $table->date('appointment_date');
            $table->string('time_slot');
            $table->enum('status', ['confirmed', 'completed', 'cancelled', 'no_show'])->default('confirmed');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
