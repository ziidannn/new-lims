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
        Schema::create('ambient_airs', function (Blueprint $table) {
            $table->id();
            $table->string('testing_result');
            $table->unsignedBigInteger('parameter_id');
            $table->foreign('parameter_id')->references('id')->on('parameters');
            $table->unsignedBigInteger('note_id');
            $table->foreign('note_id')->references('id')->on('notes');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambient_air');
    }
};
