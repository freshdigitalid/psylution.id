<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('package_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('package_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('is_online')->default(false);
            $table->integer('min_yoe')->default(0);
            $table->integer('max_yoe')->default(0);
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_details');
        Schema::dropIfExists('packages');
    }
};
