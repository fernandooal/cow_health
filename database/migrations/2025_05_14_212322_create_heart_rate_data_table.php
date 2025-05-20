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
        Schema::create('heart_rate_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensors_data_id');
            $table->integer('bpm');
            $table->timestamps();

            $table->foreign('sensors_data_id')->references('id')->on('sensors_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heart_rate_data');
    }
};
