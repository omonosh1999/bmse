<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'lesson_id',
        'category',
        'class_level',
        'max_attempts',
        'time_limit',
        'passing_score',
        'status',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_limit' => 'integer',
        'max_attempts' => 'integer',
        'passing_score' => 'integer',
    ];

    /**
     * Get the course that owns the quiz
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson that owns the quiz
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the user who created the quiz
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the questions for the quiz
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    /**
     * Get the attempts for the quiz
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Scope a query to only include published quizzes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include active quizzes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total points for this quiz
     */
    public function getTotalPointsAttribute()
    {
        return $this->questions()->sum('points');
    }

    /**
     * Check if user has exceeded attempt limit
     */
    public function hasExceededAttempts($userId)
    {
        if ($this->max_attempts === -1) {
            return false; // Unlimited attempts
        }

        $userAttempts = $this->attempts()->where('user_id', $userId)->count();
        return $userAttempts >= $this->max_attempts;
    }

    /**
     * Check if quiz has unlimited attempts
     */
    public function hasUnlimitedAttempts()
    {
        return $this->max_attempts === -1;
    }

    /**
     * Get formatted max attempts for display
     */
    public function getFormattedMaxAttemptsAttribute()
    {
        return $this->hasUnlimitedAttempts() ? 'Unlimited' : $this->max_attempts;
    }

    /**
     * Get formatted time limit for display
     */
    public function getFormattedTimeLimitAttribute()
    {
        return $this->time_limit ? $this->time_limit . ' minutes' : 'No limit';
    }

    /**
     * Get formatted passing score for display
     */
    public function getFormattedPassingScoreAttribute()
    {
        return $this->passing_score . '%';
    }

    /**
     * Get quiz statistics
     */
    public function getStatsAttribute()
    {
        $totalAttempts = $this->attempts()->count();
        $passedAttempts = $this->attempts()->where('passed', true)->count();
        $averageScore = $this->attempts()->avg('percentage');

        return [
            'total_attempts' => $totalAttempts,
            'passed_attempts' => $passedAttempts,
            'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
            'average_score' => $averageScore ? round($averageScore, 2) : 0,
        ];
    }

    /**
     * Check if quiz is ready to be published
     */
    public function canBePublished()
    {
        return $this->questions()->count() > 0;
    }

    /**
     * Get quiz difficulty based on passing score
     */
    public function getDifficultyAttribute()
    {
        if ($this->passing_score >= 80) {
            return 'Hard';
        } elseif ($this->passing_score >= 60) {
            return 'Medium';
        } else {
            return 'Easy';
        }
    }

    /**
     * Get estimated completion time
     */
    public function getEstimatedTimeAttribute()
    {
        $questionCount = $this->questions()->count();
        
        if ($this->time_limit) {
            return $this->time_limit . ' minutes (timed)';
        }
        
        // Estimate 1 minute per question if no time limit
        $estimated = max($questionCount, 5); // Minimum 5 minutes
        return "~{$estimated} minutes";
    }
}