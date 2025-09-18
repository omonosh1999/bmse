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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'true_false', 'fill_blank']);
            $table->json('options')->nullable(); // Allow NULL for fill_blank questions
            $table->string('correct_answer');
            $table->text('explanation')->nullable();
            $table->integer('points')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['quiz_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};