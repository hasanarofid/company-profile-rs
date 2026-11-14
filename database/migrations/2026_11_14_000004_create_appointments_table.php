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
            $table->string('booking_code')->unique();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->string('patient_name');
            $table->string('patient_phone', 30);
            $table->string('patient_email')->nullable();
            $table->date('patient_dob')->nullable();
            $table->string('patient_nik', 30)->nullable();
            $table->string('payment_type')->default('Umum'); // Umum, BPJS Kesehatan, Asuransi Swasta
            $table->text('complaint')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
