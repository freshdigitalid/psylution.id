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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('psychologist_id');
            $table->uuid('patient_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('complaints')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('psychologist_id')->references('id')->on('persons');
            $table->foreign('patient_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
