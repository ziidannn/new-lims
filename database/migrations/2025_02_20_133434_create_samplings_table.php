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
            $table->unsignedBigInteger('institute_id')->nullable();
            $table->foreign('institute_id')->references('id')->on('institutes');
            $table->unsignedBigInteger('institute_subject_id')->nullable();
            $table->foreign('institute_subject_id')->references('id')->on('institute_subjects');
            $table->string('no_sample')->nullable();
            $table->string('sampling_location')->nullable();
            $table->date('sampling_date')->nullable();
            $table->string('sampling_time')->nullable();
            $table->string('sampling_method')->nullable();
            $table->date('date_received')->nullable();
            $table->date('itd_start')->nullable();
            $table->date('itd_end')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
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
