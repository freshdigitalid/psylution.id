<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('break_start_time')->nullable();
            $table->dateTime('break_end_time')->nullable();
            $table->timestamps();

            $table->uuid('psychologist_id');
            $table->foreign('psychologist_id')->references('id')->on('persons')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};