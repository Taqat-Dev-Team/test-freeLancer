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
        Schema::create('free_lancer_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('freelancers')->onDelete('cascade');
            $table->string('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_lancer_languages');
    }
};
