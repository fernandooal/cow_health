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
        Schema::create('accelerometer_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id');
            $table->float('gyro_x')->nullable();
            $table->float('gyro_y')->nullable();
            $table->float('gyro_z')->nullable();
            $table->float('accel_x')->nullable();
            $table->float('accel_y')->nullable();
            $table->float('accel_z')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accelerometer_data');
    }
};
