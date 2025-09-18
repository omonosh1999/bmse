<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get the quiz that owns the question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get formatted options for display
     */
    public function getFormattedOptionsAttribute()
    {
        if (!$this->options) {
            return [];
        }

        // If options is already an associative array, return as is
        if (is_array($this->options) && array_keys($this->options) !== range(0, count($this->options) - 1)) {
            return $this->options;
        }

        // Convert indexed array to associative array
        $formatted = [];
        foreach ($this->options as $index => $option) {
            $key = chr(65 + $index); // A, B, C, D...
            $formatted[$key] = $option;
        }

        return $formatted;
    }

    /**
     * Check if a given answer is correct
     */
    public function isCorrectAnswer($answer)
    {
        switch ($this->type) {
            case 'multiple_choice':
            case 'true_false':
                return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
            
            case 'fill_blank':
                // Allow multiple correct answers separated by |
                $correctAnswers = explode('|', $this->correct_answer);
                foreach ($correctAnswers as $correctAnswer) {
                    if (strtolower(trim($answer)) === strtolower(trim($correctAnswer))) {
                        return true;
                    }
                }
                return false;
            
            default:
                return false;
        }
    }

    /**
     * Get the option key for the correct answer (for multiple choice)
     */
    public function getCorrectOptionKeyAttribute()
    {
        if ($this->type !== 'multiple_choice' || !$this->options) {
            return null;
        }

        $formattedOptions = $this->getFormattedOptionsAttribute();
        foreach ($formattedOptions as $key => $option) {
            if (strtolower(trim($option)) === strtolower(trim($this->correct_answer))) {
                return $key;
            }
        }

        return null;
    }
}