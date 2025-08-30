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
        Schema::table('appointments', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->after('patient_id');
            $table->date('appointment_date')->nullable()->after('user_id');
            $table->time('appointment_time')->nullable()->after('appointment_date');
            $table->string('consultation_type')->default('online')->after('appointment_time');
            $table->text('complaint')->nullable()->after('consultation_type');
            $table->text('notes')->nullable()->after('complaint');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending')->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'appointment_date', 'appointment_time', 'consultation_type', 'complaint', 'notes', 'status']);
        });
    }
};
