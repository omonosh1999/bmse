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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('category'); // primary, secondary
            $table->string('class_level')->nullable(); // JSS1, JSS2, SS1, etc.
            $table->integer('max_attempts')->default(-1); // -1 = unlimited
            $table->integer('time_limit')->nullable(); // in minutes
            $table->integer('passing_score')->default(70); // percentage
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['status', 'is_active']);
            $table->index(['category', 'class_level']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};