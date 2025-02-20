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
        Schema::create('resume_limses', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('address');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('sample_taken_by');
            $table->date('sample_receive_date');
            $table->date('sample_analysis_date');
            $table->date('report_date');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_limses');
    }
};
