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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('answers'); // Store user's answers as JSON
            $table->integer('score'); // Points earned
            $table->integer('total_points'); // Total possible points
            $table->decimal('percentage', 5, 2); // Percentage score
            $table->boolean('passed')->default(false); // Did they pass?
            $table->integer('time_taken')->nullable(); // Time in seconds
            $table->timestamp('completed_at'); // When completed
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['quiz_id', 'user_id']);
            $table->index(['quiz_id', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};