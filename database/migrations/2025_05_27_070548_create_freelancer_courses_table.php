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
        Schema::create('freelancer_courses', function (Blueprint $table) {
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->date('startedAt')->nullable();
            $table->date('ended_at')->nullable();
            $table->foreignId('freelancer_id')->constrained('freelancers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_courses');
    }
};
