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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sampling_id')->nullable();
            $table->foreign('sampling_id')->references('id')->on('samplings');
            $table->unsignedBigInteger('parameter_id')->nullable();
            $table->foreign('parameter_id')->references('id')->on('parameters');
            $table->string('name_parameter')->nullable();
            $table->string('sampling_time')->nullable();
            $table->string('testing_result')->nullable()->nullable();
            $table->string('regulation')->nullable();
            $table->string('unit')->nullable();
            $table->string('method')->nullable();
            $table->string('noise')->nullable();
            $table->string('leq')->nullable();
            $table->string('ls')->nullable();
            $table->string('lm')->nullable();
            $table->string('lsm')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
