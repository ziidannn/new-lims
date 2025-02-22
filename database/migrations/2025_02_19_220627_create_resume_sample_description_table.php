<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('resume_sample_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained('resume_limses')->onDelete('cascade');
            $table->foreignId('sample_description_id')->constrained('sample_descriptions')->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_sample_description');
    }
};
