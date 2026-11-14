<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code', 20)->nullable();
            $table->string('icon')->default('Stethoscope');
            $table->string('image')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->string('location')->nullable();
            $table->string('phone_ext', 30)->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};

