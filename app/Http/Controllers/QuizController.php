<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;

class QuizController extends Controller
{
    /**
     * Display all quizzes for the authenticated user
     */
    public function index()
    {
        $quizzes = Quiz::with(['course', 'lesson', 'questions'])
                       ->where('created_by', Auth::id())
                       ->latest()
                       ->paginate(10);

        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz (Step 1)
     */
    public function create()
    {
        $courses = Course::where('created_by', Auth::id())
                        ->where('status', 'published')
                        ->with('lessons')
                        ->get();

        return view('quizzes.create', compact('courses'));
    }

    /**
     * Store the basic quiz information (Step 1)
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'course_id' => 'required|exists:courses,id',
                'lesson_id' => 'required|exists:lessons,id',
                'max_attempts' => 'required|integer|min:-1',
                'time_limit' => 'nullable|integer|min:1',
                'passing_score' => 'required|integer|min:1|max:100',
            ]);

            // Verify the lesson belongs to the selected course
            $lesson = Lesson::where('id', $request->lesson_id)
                           ->where('course_id', $request->course_id)
                           ->first();

            if (!$lesson) {
                return back()->withErrors(['lesson_id' => 'Selected lesson does not belong to the selected course.']);
            }

            // Get course details for category and class_level
            $course = Course::findOrFail($request->course_id);

            $data = $request->only(['title', 'description', 'course_id', 'lesson_id', 'max_attempts', 'time_limit', 'passing_score']);
            $data['created_by'] = Auth::id();
            $data['status'] = 'draft';
            $data['category'] = $course->category;
            $data['class_level'] = $course->class_level;
            $data['is_active'] = true;

            $quiz = Quiz::create($data);

            return redirect()->route('quizzes.questions.create', $quiz)
                            ->with('success', 'Quiz created successfully! Now add your questions.');
                            
        } catch (Exception $e) {
            Log::error('Quiz creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            
            return back()->withInput()
                        ->withErrors(['general' => 'Failed to create quiz: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for adding questions (Step 2)
     */
    public function createQuestions(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $questions = $quiz->questions()->orderBy('sort_order')->get();
        
        return view('quizzes.questions', compact('quiz', 'questions'));
    }

    /**
     * Store quiz questions (Step 2)
     */
    public function storeQuestions(Request $request, Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,true_false,fill_blank',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.points' => 'required|integer|min:1',
        ]);

        // Clear existing questions
        $quiz->questions()->delete();

        foreach ($request->questions as $index => $questionData) {
            $data = [
                'quiz_id' => $quiz->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'correct_answer' => $questionData['correct_answer'],
                'explanation' => $questionData['explanation'] ?? null,
                'points' => $questionData['points'],
                'sort_order' => $index + 1,
            ];

            // Handle options based on question type
            switch ($questionData['type']) {
                case 'multiple_choice':
                    // For multiple choice, use the provided options
                    if (isset($questionData['options']) && is_array($questionData['options'])) {
                        // Filter out null values and empty strings
                        $options = array_filter($questionData['options'], function($option) {
                            return $option !== null && $option !== '';
                        });
                        $data['options'] = array_values($options); // Re-index array
                    } else {
                        $data['options'] = [];
                    }
                    break;
                    
                case 'true_false':
                    // For true/false, always use standard options
                    $data['options'] = ['true' => 'True', 'false' => 'False'];
                    break;
                    
                case 'fill_blank':
                default:
                    // For fill in the blank, set options to empty array instead of null
                    $data['options'] = [];
                    break;
            }

            QuizQuestion::create($data);
        }

        // Auto-publish the quiz after questions are added
        $quiz->update(['status' => 'published']);

        return redirect()->route('quizzes.show', $quiz)
                        ->with('success', 'Questions added successfully and quiz has been published!');
    }

    /**
     * Display the specified quiz
     */
    public function show(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quiz->load(['course', 'lesson', 'questions', 'attempts']);
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz
     */
    public function edit(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $courses = Course::where('created_by', Auth::id())
                        ->where('status', 'published')
                        ->with('lessons')
                        ->get();

        return view('quizzes.edit', compact('quiz', 'courses'));
    }

    /**
     * Update the specified quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
            'max_attempts' => 'required|integer|min:-1',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:1|max:100',
        ]);

        // Verify the lesson belongs to the selected course
        $lesson = Lesson::where('id', $request->lesson_id)
                       ->where('course_id', $request->course_id)
                       ->first();

        if (!$lesson) {
            return back()->withErrors(['lesson_id' => 'Selected lesson does not belong to the selected course.']);
        }

        // Get course details for category and class_level
        $course = Course::findOrFail($request->course_id);

        $data = $request->only(['title', 'description', 'course_id', 'lesson_id', 'max_attempts', 'time_limit', 'passing_score']);
        $data['category'] = $course->category;
        $data['class_level'] = $course->class_level;

        $quiz->update($data);

        return redirect()->route('quizzes.show', $quiz)
                        ->with('success', 'Quiz updated successfully!');
    }

    /**
     * Publish a quiz
     */
    public function publish(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        // Ensure quiz has questions
        if ($quiz->questions()->count() === 0) {
            return back()->with('error', 'Cannot publish quiz without questions.');
        }

        $quiz->update(['status' => 'published', 'is_active' => true]);

        return back()->with('success', 'Quiz published successfully!');
    }

    /**
     * Unpublish a quiz
     */
    public function unpublish(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quiz->update(['status' => 'draft', 'is_active' => false]);

        return back()->with('success', 'Quiz unpublished successfully!');
    }

    /**
     * Activate a quiz
     */
    public function activate(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quiz->update(['is_active' => true]);

        return back()->with('success', 'Quiz activated successfully!');
    }

    /**
     * Deactivate a quiz
     */
    public function deactivate(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quiz->update(['is_active' => false]);

        return back()->with('success', 'Quiz deactivated successfully!');
    }

    /**
     * Remove the specified quiz from storage
     */
    public function destroy(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quiz->delete(); // This will cascade delete questions and attempts

        return redirect()->route('quizzes.index')
                        ->with('success', 'Quiz deleted successfully!');
    }

    /**
     * Get lessons for a specific course (AJAX)
     */
    public function getLessons(Request $request)
    {
        $courseId = $request->get('course_id');
        
        $lessons = Lesson::where('course_id', $courseId)
                        ->orderBy('sort_order')
                        ->get(['id', 'title']);
        
        return response()->json($lessons);
    }

    /**
     * View quiz attempts and analytics
     */
    public function attempts(Quiz $quiz)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $attempts = $quiz->attempts()
                        ->with('user')
                        ->latest()
                        ->paginate(20);

        // Calculate analytics
        $totalAttempts = $quiz->attempts()->count();
        $passedAttempts = $quiz->attempts()->where('passed', true)->count();
        $averageScore = $quiz->attempts()->avg('percentage');
        $averageTime = $quiz->attempts()->whereNotNull('time_taken')->avg('time_taken');

        $analytics = [
            'total_attempts' => $totalAttempts,
            'passed_attempts' => $passedAttempts,
            'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
            'average_score' => round($averageScore, 2),
            'average_time' => $averageTime ? round($averageTime / 60, 2) : null, // Convert to minutes
        ];

        return view('quizzes.attempts', compact('quiz', 'attempts', 'analytics'));
    }

    /**
     * View specific attempt details
     */
    public function viewAttempt(Quiz $quiz, $attemptId)
    {
        // Ensure user owns this quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $attempt = $quiz->attempts()->with('user')->findOrFail($attemptId);
        $detailedResults = $attempt->getDetailedResults();

        return view('quizzes.attempt-detail', compact('quiz', 'attempt', 'detailedResults'));
    }

    // ==========================================
    // QUESTION MANAGEMENT METHODS
    // ==========================================

    /**
     * Store a new question for a quiz
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,true_false,fill_blank',
            'points' => 'required|integer|min:1|max:100',
            'explanation' => 'nullable|string|max:1000',
            'correct_answer' => 'required|string',
            'options' => 'nullable|string', // JSON string for multiple choice
        ]);

        // Check if user owns the quiz
        $quiz = Quiz::where('id', $request->quiz_id)
                   ->where('created_by', Auth::id())
                   ->firstOrFail();

        // Get the next sort order
        $sortOrder = $quiz->questions()->max('sort_order') + 1;

        // Prepare data for storage
        $data = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'type' => $request->type,
            'points' => $request->points,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'sort_order' => $sortOrder,
        ];

        // Handle options for multiple choice
        if ($request->type === 'multiple_choice' && $request->options) {
            $options = json_decode($request->options, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['options'] = $options;
            }
        } else {
            $data['options'] = [];
        }

        $question = QuizQuestion::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully',
            'question' => $question
        ]);
    }

    /**
     * Show a specific question
     */
    public function showQuestion($questionId)
    {
        $question = QuizQuestion::findOrFail($questionId);
        
        // Check if user owns the quiz
        if ($question->quiz->created_by !== Auth::id()) {
            abort(403);
        }

        return response()->json($question);
    }

    /**
     * Update a specific question
     */
    public function updateQuestion(Request $request, $questionId)
    {
        $question = QuizQuestion::findOrFail($questionId);
        
        // Check if user owns the quiz
        if ($question->quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,true_false,fill_blank',
            'points' => 'required|integer|min:1|max:100',
            'explanation' => 'nullable|string|max:1000',
            'correct_answer' => 'required|string',
            'options' => 'nullable|string', // JSON string for multiple choice
        ]);

        // Prepare data for update
        $data = [
            'question' => $request->question,
            'type' => $request->type,
            'points' => $request->points,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ];

        // Handle options for multiple choice
        if ($request->type === 'multiple_choice' && $request->options) {
            $options = json_decode($request->options, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['options'] = $options;
            }
        } else {
            $data['options'] = [];
        }

        $question->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Question updated successfully',
            'question' => $question->fresh()
        ]);
    }

    /**
     * Delete a specific question
     */
    public function destroyQuestion($questionId)
    {
        $question = QuizQuestion::findOrFail($questionId);
        
        // Check if user owns the quiz
        if ($question->quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $quizId = $question->quiz_id;
        $question->delete();

        // Resequence remaining questions (FIXED: renamed method call)
        $this->resequenceQuestions($quizId);

        return response()->json([
            'success' => true,
            'message' => 'Question deleted successfully'
        ]);
    }

    /**
     * Resequence questions after deletion (FIXED: renamed from reorderQuestions to avoid conflict)
     */
    private function resequenceQuestions($quizId)
    {
        $questions = QuizQuestion::where('quiz_id', $quizId)
                                ->orderBy('sort_order')
                                ->get();

        foreach ($questions as $index => $question) {
            $question->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Update question order (public API method - FIXED: kept original name for routes)
     */
    public function reorderQuestions(Request $request, Quiz $quiz)
    {
        // Check if user owns the quiz
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:quiz_questions,id'
        ]);

        foreach ($request->question_ids as $index => $questionId) {
            QuizQuestion::where('id', $questionId)
                       ->where('quiz_id', $quiz->id)
                       ->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Questions reordered successfully'
        ]);
    }
}