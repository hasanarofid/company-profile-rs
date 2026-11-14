<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Medis'); // Medis, Keperawatan, Penunjang Medis, Non-Medis & IT
            $table->string('employment_type')->default('Full-Time');
            $table->string('location')->default('Gedung Utama RS');
            $table->string('department_name')->nullable();
            $table->text('description');
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};

