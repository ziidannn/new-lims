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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('sampling_time_id');
            $table->foreign('sampling_time_id')->references('id')->on('sampling_times');
            $table->unsignedBigInteger('regulation_id');
            $table->foreign('regulation_id')->references('id')->on('regulations');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->unsignedBigInteger('method_id');
            $table->foreign('method_id')->references('id')->on('methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
