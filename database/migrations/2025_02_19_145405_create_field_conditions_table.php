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
            $table->string(column: 'coordinate'); // Bisa disesuaikan dengan format koordinat
            $table->float('temperature');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->float('wind_speed');
            $table->integer('wind_direction');
            $table->string('weather'); // Bisa diubah jika membutuhkan lebih banyak informasi
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
