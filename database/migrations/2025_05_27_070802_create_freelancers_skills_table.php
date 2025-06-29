<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freelancers_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('freelancers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers_skills');
    }
};
