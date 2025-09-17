<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'class_level',
        'instructor',
        'cover_photo',
        'status',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the course
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all lessons for this course
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    /**
     * Get class options based on category
     */
    public static function getClassOptions(string $category): array
    {
        if ($category === 'primary') {
            return [
                'Class 1' => 'Class 1',
                'Class 2' => 'Class 2',
                'Class 3' => 'Class 3',
                'Class 4' => 'Class 4',
                'Class 5' => 'Class 5',
                'Class 6' => 'Class 6',
            ];
        }

        if ($category === 'secondary') {
            return [
                'Form 1' => 'Form 1',
                'Form 2' => 'Form 2',
                'Form 3' => 'Form 3',
                'Form 4' => 'Form 4',
                'Form 5' => 'Form 5',
                'Form 6' => 'Form 6',
            ];
        }

        return [];
    }

    /**
     * Scope for published courses
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for draft courses
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}