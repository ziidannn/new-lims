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
        Schema::create('heat_stresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sampling_id')->nullable();
            $table->foreign('sampling_id')->references('id')->on('samplings');
            $table->string('sampling_location')->nullable();
            $table->string('time')->nullable();
            $table->string('humidity')->nullable();
            $table->string('wet')->nullable();
            $table->string('dew')->nullable();
            $table->string('globe')->nullable();
            $table->string('wbgt_index')->nullable();
            $table->string('methods')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heat_stresses');
    }
};
