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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sample_description_id')->nullable();
            $table->foreign('sample_description_id')->references('id')->on('sample_descriptions');
            $table->string('name_parameter');
            $table->string('sampling_time');
            $table->string('testing_result')->nullable();
            $table->string('regulation');
            $table->string('unit');
            $table->string('method');
            $table->unsignedBigInteger('sampling_id')->nullable();
            $table->foreign('sampling_id')->references('id')->on('samplings');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
