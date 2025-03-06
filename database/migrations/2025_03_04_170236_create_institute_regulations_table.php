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
        Schema::create('institute_regulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institute_subject_id');
            $table->foreign('institute_subject_id')->references('id')->on('institute_subjects');
            $table->unsignedBigInteger('regulation_id');
            $table->foreign('regulation_id')->references('id')->on('regulations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_regulations');
    }
};
