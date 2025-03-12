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
            $table->foreign('result_id')->references('id')->on('results')->onDelete('cascade'); // Perbaikan foreign key
            $table->string('coordinate')->nullable(); 
            $table->string('temperature')->nullable();
            $table->string('pressure')->nullable();
            $table->string('humidity')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_direction')->nullable();
            $table->string('weather')->nullable(); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Perbaikan untuk updated_at
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
