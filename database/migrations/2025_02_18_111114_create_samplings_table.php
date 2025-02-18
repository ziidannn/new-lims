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
        Schema::create('samplings', function (Blueprint $table) {
            $table->id();
            $table->string('no_sample');
            $table->date('date');
            $table->time('time');
            $table->string('method');
            $table->date('date_received');
            $table->date('interval_testing_date');
            $table->unsignedBigInteger('sample_description_id');
            $table->foreign('sample_description_id')->references('id')->on('sample_descriptions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samplings');
    }
};
