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
        Schema::create('freelancer_education', function (Blueprint $table) {
            $table->foreignId('freelancer_id')->constrained('freelancers')->onDelete('cascade');
            $table->foreignId('education_level_id')->constrained('education_levels');
            $table->string('university', 255);
            $table->string('field_of_study', 255);
            $table->string('grade', 255);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_education');
    }
};
