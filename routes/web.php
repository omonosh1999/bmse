<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/primary', [PublicController::class, 'primary'])->name('primary');
Route::get('/secondary', [PublicController::class, 'secondary'])->name('secondary');

// Public Course Preview (no auth required)
Route::get('/courses/{course}/preview', [PublicController::class, 'coursePreview'])->name('courses.preview');

Route::get('/mental', function () {
    return view('mental');
})->name('mental');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/services', function () {
    return view('services');
})->name('services');

// Contact routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Dashboard (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Course Management Routes (all protected)
    Route::resource('courses', CourseController::class);
    
    // Course Curriculum Routes (Step 2 of course creation)
    Route::get('courses/{course}/curriculum', [CourseController::class, 'createCurriculum'])
         ->name('courses.curriculum.create');
    Route::post('courses/{course}/curriculum', [CourseController::class, 'storeCurriculum'])
         ->name('courses.curriculum.store');
    
    // Course Publishing Routes
    Route::patch('courses/{course}/publish', [CourseController::class, 'publish'])
         ->name('courses.publish');
    Route::patch('courses/{course}/unpublish', [CourseController::class, 'unpublish'])
         ->name('courses.unpublish');
    
    // AJAX Route for dynamic class options
    Route::get('api/class-options', [CourseController::class, 'getClassOptions'])
         ->name('api.class-options');
});

// Authentication routes
require __DIR__.'/auth.php';