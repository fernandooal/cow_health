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
        Schema::create('temperature_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensors_data_id');
            $table->float('temperature');
            $table->timestamps();

            $table->foreign('sensors_data_id')->references('id')->on('sensors_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperature_data');
    }
};
