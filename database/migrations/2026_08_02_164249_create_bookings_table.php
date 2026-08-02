<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('service_ids')->nullable();
            $table->string('client_name');
            $table->string('client_phone');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->date('original_date')->nullable();
            $table->time('original_time')->nullable();
            $table->enum('location_type', ['studio', 'home'])->default('studio');
            $table->text('location_details')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rescheduled', 'cancelled'])->default('pending');
            $table->foreignId('status_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('client_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};