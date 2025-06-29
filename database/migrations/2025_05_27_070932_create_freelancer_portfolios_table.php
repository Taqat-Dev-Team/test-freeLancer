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
        Schema::create('freelancer_portfolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('freelancer_id')->index();
            $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->json('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_portfolios');
    }
};
