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
        Schema::create('sampling_time_regulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parameter_id')->nullable();
            $table->foreign('parameter_id')->references('id')->on('parameters');
            $table->unsignedBigInteger('sampling_time_id')->nullable();
            $table->foreign('sampling_time_id')->references('id')->on('sampling_times');
            $table->unsignedBigInteger('regulation_standard_id')->nullable();
            $table->foreign('regulation_standard_id')->references('id')->on('regulation_standards');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling_time_regulations');
    }
};
