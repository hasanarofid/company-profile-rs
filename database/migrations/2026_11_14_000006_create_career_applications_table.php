<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained('careers')->cascadeOnDelete();
            $table->string('applicant_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('education')->nullable();
            $table->text('experience_summary')->nullable();
            $table->string('cv_path');
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('submitted'); // submitted, reviewed, interview, accepted, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
