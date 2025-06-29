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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['fixed', 'hourly']);
            $table->decimal('fixed_price', 10, 2)->nullable();
            $table->integer('duration_days')->nullable();
            $table->decimal('hourly_price', 10, 2)->nullable();
            $table->integer('weekly_hours')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('freelancer_id')->nullable()->constrained('freelancers')->onDelete('set null');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
