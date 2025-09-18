<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',        // NULL for guests
        'answers',
        'score',
        'total_points',
        'percentage',
        'passed',
        'time_taken',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'integer',
        'total_points' => 'integer',
        'percentage' => 'decimal:2',
        'passed' => 'boolean',
        'time_taken' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the quiz that owns the attempt.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user who made the attempt (null for guest attempts).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is a guest attempt.
     */
    public function isGuestAttempt(): bool
    {
        return $this->user_id === null;
    }

    /**
     * Get the name of who made the attempt.
     */
    public function getAttemptOwnerAttribute(): string
    {
        return $this->user ? $this->user->name : 'Guest User';
    }

    /**
     * Get formatted time taken.
     */
    public function getFormattedTimeTakenAttribute(): string
    {
        if (!$this->time_taken) {
            return 'N/A';
        }

        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get the grade/result as text.
     */
    public function getGradeAttribute(): string
    {
        if ($this->percentage >= 90) return 'A';
        if ($this->percentage >= 80) return 'B';
        if ($this->percentage >= 70) return 'C';
        if ($this->percentage >= 60) return 'D';
        return 'F';
    }

    /**
     * Scope to get attempts by authenticated users only.
     */
    public function scopeAuthenticatedUsers($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope to get guest attempts only.
     */
    public function scopeGuestAttempts($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope to get passing attempts.
     */
    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    /**
     * Scope to get failing attempts.
     */
    public function scopeFailed($query)
    {
        return $query->where('passed', false);
    }
}