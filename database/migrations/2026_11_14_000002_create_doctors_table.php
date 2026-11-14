<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('specialization');
            $table->string('sub_specialization')->nullable();
            $table->string('sip_number')->nullable();
            $table->string('photo')->nullable();
            $table->text('education')->nullable();
            $table->integer('experience_years')->default(5);
            $table->text('bio')->nullable();
            $table->string('consultation_fee')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
