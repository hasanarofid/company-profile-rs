<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->string('day_of_week'); // Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu
            $table->tinyInteger('day_order')->default(1); // 1=Senin .. 7=Minggu
            $table->string('start_time', 10); // 08:00
            $table->string('end_time', 10);   // 12:00
            $table->string('room')->nullable();
            $table->integer('quota')->default(20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};

