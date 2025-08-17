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
        Schema::create('psychologists_specializations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('psychologist_id');
            $table->foreign('psychologist_id')->references('id')->on('persons')->onDelete('cascade');

            $table->uuid('specialization_id');
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psychologists_specializations');
    }
};