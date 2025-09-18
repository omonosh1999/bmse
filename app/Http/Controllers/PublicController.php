<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Home page - Display all published courses (guest-safe)
     */
    public function home()
    {
        $courses = Course::where('status', 'published')
            ->with(['lessons', 'user']) // user relationship is now safe
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('class'), function ($query) {
                $query->where('class_level', request('class'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get available class levels for filter dropdown
        $availableClasses = Course::where('status', 'published')
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('welcome', compact('courses', 'availableClasses'));
    }

    /**
     * Primary level courses (guest-safe)
     */
    public function primary()
    {
        $courses = Course::where('status', 'published')
            ->where('category', 'primary')
            ->with(['lessons', 'user'])
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('class'), function ($query) {
                $query->where('class_level', request('class'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get available class levels for filter dropdown
        $availableClasses = Course::where('status', 'published')
            ->where('category', 'primary')
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('primary', compact('courses', 'availableClasses'));
    }

    /**
     * Secondary level courses (guest-safe)
     * FIXED: Changed to use 'form' parameter and $availableForms variable
     */
    public function secondary()
    {
        $courses = Course::where('status', 'published')
            ->where('category', 'secondary')
            ->with(['lessons', 'user'])
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('form'), function ($query) {  // CHANGED: from 'class' to 'form'
                $query->where('class_level', request('form'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // CHANGED: Variable name from $availableClasses to $availableForms
        $availableForms = Course::where('status', 'published')
            ->where('category', 'secondary')
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('secondary', compact('courses', 'availableForms'));
    }

    /**
     * Course preview page (guest-safe)
     */
    public function coursePreview(Course $course, Request $request)
    {
        // Ensure course is published
        if ($course->status !== 'published') {
            abort(404);
        }

        // Load course with lessons and user
        $course->load(['lessons' => function ($query) {
            $query->orderBy('sort_order');
        }, 'user']);

        // Get all lessons for this course
        $lessons = $course->lessons;

        // Get current lesson index from URL parameter (default to 0)
        $currentLessonIndex = (int) $request->get('lesson', 0);
        
        // Ensure lesson index is valid
        if ($currentLessonIndex < 0 || $currentLessonIndex >= $lessons->count()) {
            $currentLessonIndex = 0;
        }

        // Get current lesson (null if course is complete)
        $currentLesson = $lessons->get($currentLessonIndex);

        return view('course-preview', compact('course', 'lessons', 'currentLesson', 'currentLessonIndex'));
    }

    /**
     * Mental Math page - Display all published quizzes (guest-safe)
     * FIXED: Aligned variable names with template expectations
     */
    public function mental()
    {
        $quizzes = Quiz::where('status', 'published')
            ->where('is_active', true)
            ->with(['course', 'lesson', 'questions', 'user'])
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($query) {
                $query->where('category', request('category'));
            })
            ->when(request('class'), function ($query) {  // CHANGED: from 'class_level' to 'class'
                $query->where('class_level', request('class'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get filter options with correct variable names
        $availableCategories = Quiz::where('status', 'published')
            ->where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort();

        // CHANGED: Variable name to match template (for when class filter is uncommented)
        $availableClasses = Quiz::where('status', 'published')
            ->where('is_active', true)
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('mental', compact('quizzes', 'availableCategories', 'availableClasses'));
    }

    /**
     * Take a quiz (handles both guests and authenticated users)
     */
    public function quizTake(Quiz $quiz)
    {
        // Check if quiz is published and active
        if ($quiz->status !== 'published' || !$quiz->is_active) {
            abort(404);
        }

        // Check attempt limits only if user is authenticated
        if (Auth::check() && $quiz->max_attempts > 0) {
            $userAttempts = QuizAttempt::where('quiz_id', $quiz->id)
                ->where('user_id', Auth::id())
                ->count();

            if ($userAttempts >= $quiz->max_attempts) {
                return redirect()->route('mental')
                    ->with('error', 'You have reached the maximum number of attempts for this quiz.');
            }
        }

        $quiz->load(['questions' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return view('quizzes.take', compact('quiz'));
    }

    /**
 * Submit quiz answers (handles both guests and authenticated users)
 */
public function quizSubmit(Request $request, Quiz $quiz)
{
    // Check if quiz is published and active
    if ($quiz->status !== 'published' || !$quiz->is_active) {
        abort(404);
    }

    $request->validate([
        'answers' => 'required|array',
        'time_taken' => 'nullable|integer|min:1',
    ]);

    $quiz->load(['questions' => function ($query) {
        $query->orderBy('sort_order');
    }]);

    // Calculate score
    $totalPoints = $quiz->questions->sum('points');
    $earnedPoints = 0;
    $results = [];

    foreach ($quiz->questions as $question) {
        $userAnswer = $request->answers[$question->id] ?? null;
        $isCorrect = $this->checkAnswer($question, $userAnswer);
        
        if ($isCorrect) {
            $earnedPoints += $question->points;
        }

        $results[$question->id] = [
            'question' => $question->question,
            'user_answer' => $userAnswer,
            'correct_answer' => $question->correct_answer,
            'is_correct' => $isCorrect,
            'points' => $isCorrect ? $question->points : 0,
            'explanation' => $question->explanation,
        ];
    }

    $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
    $passed = $percentage >= $quiz->passing_score;

    // Optional: Store guest attempts in session for current visit tracking
    if (!Auth::check()) {
        $guestAttempts = session()->get('guest_quiz_attempts', []);
        $guestAttempts[] = [
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'score' => $percentage,
            'passed' => $passed,
            'completed_at' => now()->toDateTimeString(),
        ];
        session()->put('guest_quiz_attempts', $guestAttempts);
    }

    // Create attempt record (user_id will be null for guests - that's fine!)
    $attempt = QuizAttempt::create([
        'quiz_id' => $quiz->id,
        'user_id' => Auth::id(), // NULL for guests
        'answers' => $request->answers,
        'score' => $earnedPoints,
        'total_points' => $totalPoints,
        'percentage' => $percentage,
        'passed' => $passed,
        'time_taken' => $request->time_taken,
        'completed_at' => now(),
    ]);

    return redirect()->route('quiz.results', $attempt)
        ->with('success', $passed ? 'Congratulations! You passed the quiz.' : 'Quiz completed. Review your results below.');
}

    /**
 * Show quiz results (guest-safe)
 */
public function quizResults(QuizAttempt $attempt)
{
    $attempt->load(['quiz.questions' => function ($query) {
        $query->orderBy('sort_order');
    }]);

    $detailedResults = [];
    foreach ($attempt->quiz->questions as $question) {
        $userAnswer = $attempt->answers[$question->id] ?? null;
        $isCorrect = $this->checkAnswer($question, $userAnswer);
        
        // Use formatted options for consistent display
        $options = $question->type === 'multiple_choice' ? $question->formatted_options : $question->options;
        
        $detailedResults[] = [
            'question' => $question->question,
            'type' => $question->type,
            'options' => $options,
            'user_answer' => $userAnswer,
            'correct_answer' => $question->correct_answer,
            'is_correct' => $isCorrect,
            'points' => $isCorrect ? $question->points : 0,
            'explanation' => $question->explanation,
        ];
    }

    return view('quizzes.results', compact('attempt', 'detailedResults'));
}

    /**
     * About Us page (guest-safe)
     */
    public function aboutUs()
    {
        return view('about-us');
    }

    /**
     * Services page (guest-safe)
     */
    public function services()
    {
        return view('services');
    }

    /**
     * Contact page (guest-safe)
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Helper method to check if answer is correct
     */
    private function checkAnswer($question, $userAnswer)
    {
        if (empty($userAnswer)) {
            return false;
        }

        switch ($question->type) {
            case 'multiple_choice':
            case 'true_false':
                return strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
            
            case 'fill_blank':
                // More flexible matching for fill in the blank
                $correctAnswers = explode('|', $question->correct_answer);
                foreach ($correctAnswers as $correctAnswer) {
                    if (strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer))) {
                        return true;
                    }
                }
                return false;
            
            default:
                return false;
        }
    }
}