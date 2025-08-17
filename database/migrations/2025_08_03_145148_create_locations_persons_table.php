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
        Schema::create('locations_persons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('person_id');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');

            $table->uuid('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations_persons');
    }
};