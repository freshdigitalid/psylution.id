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
        Schema::create('psychologists_packages', function (Blueprint $table) {
            $table->uuid('psychologist_id');
            $table->foreign('psychologist_id')->references('id')->on('persons')->restrictOnDelete();

            $table->uuid('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->restrictOnDelete();

            $table->primary(['psychologist_id', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psychologists_packages');
    }
};