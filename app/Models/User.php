<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all courses created by this user
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * Get published courses created by this user
     */
    public function publishedCourses(): HasMany
    {
        return $this->courses()->where('status', 'published');
    }

    /**
     * Get draft courses created by this user
     */
    public function draftCourses(): HasMany
    {
        return $this->courses()->where('status', 'draft');
    }

    /**
     * Get the quizzes created by this user
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }

    /**
     * Get the quiz attempts by this user
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get published and active quizzes by this user
     */
    public function activeQuizzes(): HasMany
    {
        return $this->quizzes()->where('status', 'published')->where('is_active', true);
    }

    /**
     * Get user's content statistics (safe for guests)
     */
    public function getStatsAttribute()
    {
        return [
            'total_courses' => $this->courses()->count(),
            'published_courses' => $this->publishedCourses()->count(),
            'total_quizzes' => $this->quizzes()->count(),
            'active_quizzes' => $this->activeQuizzes()->count(),
        ];
    }

    /**
     * Check if user is content creator (has courses or quizzes)
     */
    public function isContentCreator()
    {
        return $this->courses()->exists() || $this->quizzes()->exists();
    }

    /**
     * Get the user's initials for avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get display name - safe for guests
     */
    public function getDisplayNameAttribute()
    {
        return $this->name ?? 'Anonymous';
    }

    /**
     * Static method to get current user or return null for guests
     */
    public static function currentUser()
    {
        return auth()->user();
    }

    /**
     * Static method to check if current user is authenticated
     */
    public static function isAuthenticated()
    {
        return auth()->check();
    }

    /**
     * Static method to get current user ID or null for guests
     */
    public static function currentUserId()
    {
        return auth()->id();
    }
}