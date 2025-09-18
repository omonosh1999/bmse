<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContactController;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// PUBLIC PAGES (No Authentication Required)
// ==========================================

// Main public pages
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/primary', [PublicController::class, 'primary'])->name('primary');
Route::get('/secondary', [PublicController::class, 'secondary'])->name('secondary');
Route::get('/mental', [PublicController::class, 'mental'])->name('mental');
Route::get('/about-us', [PublicController::class, 'aboutUs'])->name('about-us');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

// Course preview (public access)
Route::get('/courses/{course}/preview', [PublicController::class, 'coursePreview'])->name('courses.preview');

// Quiz/Mental Math routes (public access)
Route::get('/quiz/{quiz}/take', [PublicController::class, 'quizTake'])->name('quiz.take');
Route::post('/quiz/{quiz}/submit', [PublicController::class, 'quizSubmit'])->name('quiz.submit');
Route::get('/quiz/results/{attempt}', [PublicController::class, 'quizResults'])->name('quiz.results');

// Contact form submission
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ==========================================
// AUTHENTICATED ROUTES (Dashboard & Management)
// ==========================================

// Dashboard (protected) - Replace the existing dashboard route with this
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Get courses statistics
    $totalCourses = Course::where('created_by', $user->id)->count();
    $publishedCourses = Course::where('created_by', $user->id)
                             ->where('status', 'published')
                             ->count();
    
    // Get quizzes statistics
    $totalQuizzes = Quiz::where('created_by', $user->id)->count();
    $activeQuizzes = Quiz::where('created_by', $user->id)
                        ->where('status', 'published')
                        ->where('is_active', true)
                        ->count();
    
    // Get recent courses (last 5)
    $recentCourses = Course::where('created_by', $user->id)
                          ->with(['lessons'])
                          ->withCount('lessons')
                          ->latest()
                          ->take(5)
                          ->get();
    
    // Get recent quizzes (last 5)
    $recentQuizzes = Quiz::where('created_by', $user->id)
                        ->with(['questions', 'attempts'])
                        ->withCount(['questions', 'attempts'])
                        ->latest()
                        ->take(5)
                        ->get();
    
    return view('dashboard', compact(
        'totalCourses',
        'publishedCourses', 
        'totalQuizzes',
        'activeQuizzes',
        'recentCourses',
        'recentQuizzes'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

// All authenticated routes
Route::middleware('auth')->group(function () {
    
    // ==========================================
    // PROFILE MANAGEMENT
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ==========================================
    // COURSE MANAGEMENT (Full CRUD)
    // ==========================================
    Route::resource('courses', CourseController::class);
    
    // Course Curriculum Management (Step 2 of course creation)
    Route::get('courses/{course}/curriculum', [CourseController::class, 'createCurriculum'])
         ->name('courses.curriculum.create');
    Route::post('courses/{course}/curriculum', [CourseController::class, 'storeCurriculum'])
         ->name('courses.curriculum.store');
    
    // Course Publishing Controls
    Route::patch('courses/{course}/publish', [CourseController::class, 'publish'])
         ->name('courses.publish');
    Route::patch('courses/{course}/unpublish', [CourseController::class, 'unpublish'])
         ->name('courses.unpublish');
    
    // ==========================================
    // QUIZ MANAGEMENT (Full CRUD)
    // ==========================================
    Route::resource('quizzes', QuizController::class);
    
    // Quiz Questions Management (Step 2 of quiz creation)
    Route::get('quizzes/{quiz}/questions', [QuizController::class, 'createQuestions'])
         ->name('quizzes.questions.create');
    Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestions'])
         ->name('quizzes.questions.store');
    
    // Quiz Publishing Controls
    Route::patch('quizzes/{quiz}/publish', [QuizController::class, 'publish'])
         ->name('quizzes.publish');
    Route::patch('quizzes/{quiz}/unpublish', [QuizController::class, 'unpublish'])
         ->name('quizzes.unpublish');
    
    // Quiz Activation Controls
    Route::patch('quizzes/{quiz}/activate', [QuizController::class, 'activate'])
         ->name('quizzes.activate');
    Route::patch('quizzes/{quiz}/deactivate', [QuizController::class, 'deactivate'])
         ->name('quizzes.deactivate');
    
    // Quiz Analytics & Reports
    Route::get('quizzes/{quiz}/attempts', [QuizController::class, 'attempts'])
         ->name('quizzes.attempts');
    Route::get('quizzes/{quiz}/attempts/{attempt}', [QuizController::class, 'viewAttempt'])
         ->name('quizzes.attempts.view');
    
    // ==========================================
    // QUIZ QUESTION MANAGEMENT (AJAX Routes)
    // ==========================================
    
    // Individual Question CRUD Operations - FIXED: Added {quiz} parameter
    Route::post('/quizzes/{quiz}/questions/single', [QuizController::class, 'storeQuestion'])
     ->name('quizzes.questions.store.single');
    Route::get('/quizzes/{quiz}/questions/{questionId}', [QuizController::class, 'showQuestion'])
         ->name('quizzes.questions.show');
    Route::put('/quizzes/{quiz}/questions/{questionId}', [QuizController::class, 'updateQuestion'])
         ->name('quizzes.questions.update');
    Route::delete('/quizzes/{quiz}/questions/{questionId}', [QuizController::class, 'destroyQuestion'])
         ->name('quizzes.questions.destroy');
    
    // Question Reordering
    Route::post('/quizzes/{quiz}/questions/reorder', [QuizController::class, 'reorderQuestions'])
         ->name('quizzes.questions.reorder');
    
    // ==========================================
    // AJAX/API ROUTES (for dynamic dropdowns)
    // ==========================================
    Route::get('api/class-options', [CourseController::class, 'getClassOptions'])
         ->name('api.class-options');
    Route::get('api/lessons', [QuizController::class, 'getLessons'])
         ->name('api.lessons');
});

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
require __DIR__.'/auth.php';