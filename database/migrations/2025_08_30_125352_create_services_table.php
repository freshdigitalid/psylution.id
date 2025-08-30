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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Essential, Professional, Premium, Basic
            $table->string('category'); // Counseling Corner, e-Counseling
            $table->string('type'); // Individual, Group, etc.
            $table->decimal('price', 10, 2); // Price per session
            $table->string('currency', 3)->default('IDR'); // Currency
            $table->integer('duration_minutes')->default(60); // Session duration
            $table->text('description')->nullable(); // Service description
            $table->json('features')->nullable(); // Features as JSON array
            $table->json('psychologist_criteria')->nullable(); // Psychologist criteria as JSON
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
