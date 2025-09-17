<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',        // ← Make sure this is included
        'title',
        'description',
        'material_type',
        'material_path',
        'sort_order'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the course this lesson belongs to
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if the material is a file
     */
    public function isFile(): bool
    {
        return $this->material_type === 'file';
    }

    /**
     * Check if the material is a URL
     */
    public function isUrl(): bool
    {
        return $this->material_type === 'url';
    }

    /**
     * Get the file extension if it's a file
     */
    public function getFileExtension(): ?string
    {
        if ($this->isFile() && $this->material_path) {
            return pathinfo($this->material_path, PATHINFO_EXTENSION);
        }
        return null;
    }

    /**
     * Check if the material is a video file
     */
    public function isVideo(): bool
    {
        if ($this->isUrl()) {
            return str_contains($this->material_path, 'youtube.com') || 
                   str_contains($this->material_path, 'youtu.be') ||
                   str_contains($this->material_path, 'vimeo.com');
        }

        if ($this->isFile()) {
            $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
            return in_array(strtolower($this->getFileExtension()), $videoExtensions);
        }

        return false;
    }

    /**
     * Check if the material is a PDF
     */
    public function isPdf(): bool
    {
        return $this->isFile() && strtolower($this->getFileExtension()) === 'pdf';
    }
}