<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_weekly_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration')->default(60);
            $table->integer('break_between_slots')->default(0);
            $table->boolean('is_available')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['day_of_week', 'start_time', 'end_time']);
            $table->index(['day_of_week', 'is_available']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_weekly_schedules');
    }
};