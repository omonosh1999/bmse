<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'description',
    'category',
    'class_level', 
    'instructor',  // Add this line
    'status',
    'created_by',
];

    protected $casts = [
        'created_by' => 'integer',
    ];

    /**
     * Get the user who created the course
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the lessons for the course
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    /**
     * Get the quizzes for the course
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Scope a query to only include published courses
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by class level
     */
    public function scopeClassLevel($query, $classLevel)
    {
        return $query->where('class_level', $classLevel);
    }

    /**
     * Get the total duration of all lessons in minutes
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons->sum('duration') ?? 0;
    }

    /**
     * Get formatted duration for display
     */
    public function getFormattedDurationAttribute()
    {
        $totalMinutes = $this->total_duration;
        
        if ($totalMinutes < 60) {
            return $totalMinutes . ' min';
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        if ($minutes > 0) {
            return $hours . 'h ' . $minutes . 'min';
        }
        
        return $hours . 'h';
    }

    /**
     * Get course difficulty based on class level
     */
    public function getDifficultyAttribute()
    {
        if (!$this->class_level) {
            return 'Unknown';
        }

        $level = strtolower($this->class_level);
        
        if (strpos($level, 'class 1') !== false || strpos($level, 'class 2') !== false || strpos($level, 'class 3') !== false) {
            return 'Beginner';
        } elseif (strpos($level, 'class 4') !== false || strpos($level, 'class 5') !== false || strpos($level, 'class 6') !== false) {
            return 'Intermediate';
        } else {
            return 'Advanced';
        }
    }

    /**
     * Get course progress for a specific user
     */
    public function getProgressForUser($userId)
    {
        $totalLessons = $this->lessons->count();
        
        if ($totalLessons === 0) {
            return 0;
        }

        // You can implement lesson completion tracking here
        // For now, return 0 as placeholder
        $completedLessons = 0;
        
        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    /**
     * Check if course can be published
     */
    public function canBePublished()
    {
        return $this->lessons()->count() > 0;
    }

    /**
     * Get the author name
     */
    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown Author';
    }

    /**
     * Get formatted category for display
     */
    public function getFormattedCategoryAttribute()
    {
        return ucfirst($this->category);
    }

    /**
     * Get course statistics
     */
    public function getStatsAttribute()
    {
        return [
            'lessons_count' => $this->lessons->count(),
            'quizzes_count' => $this->quizzes->count(),
            'total_duration' => $this->total_duration,
            'difficulty' => $this->difficulty,
        ];
    }

    /**
     * Get class options based on category
     */
    public static function getClassOptions($category)
    {
        $options = [];
        
        if ($category === 'primary') {
            $options = [
                'primary_class_1' => 'Primary Class 1',
                'primary_class_2' => 'Primary Class 2', 
                'primary_class_3' => 'Primary Class 3',
                'primary_class_4' => 'Primary Class 4',
                'primary_class_5' => 'Primary Class 5',
                'primary_class_6' => 'Primary Class 6',
            ];
        } elseif ($category === 'secondary') {
            $options = [
                'secondary_class_1' => 'Secondary Class 1',
                'secondary_class_2' => 'Secondary Class 2',
                'secondary_class_3' => 'Secondary Class 3',
                'secondary_class_4' => 'Secondary Class 4',
                'secondary_class_5' => 'Secondary Class 5',
                'secondary_class_6' => 'Secondary Class 6',
            ];
        }
        
        return $options;
    }
}