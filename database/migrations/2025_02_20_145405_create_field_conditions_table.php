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
        Schema::create('field_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id')->nullable();
            $table->foreign('result_id')->references('id')->on('results')->nullable();
            $table->string(column: 'coordinate')->nullable(); // Bisa disesuaikan dengan format koordinat
            $table->string('temperature')->nullable();
            $table->string('pressure')->nullable();
            $table->string('humidity')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_direction')->nullable();
            $table->string('weather')->nullable(); // Bisa diubah jika membutuhkan lebih banyak informasi
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_conditions');
    }
};
