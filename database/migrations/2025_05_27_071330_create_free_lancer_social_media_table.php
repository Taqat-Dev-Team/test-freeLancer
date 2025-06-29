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
        Schema::create('free_lancer_social_media', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->foreignId('social_media_id')->constrained('social_media')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('freelancers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_lancer_social_media');
    }
};
