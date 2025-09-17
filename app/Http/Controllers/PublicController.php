<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function coursePreview(Course $course, Request $request)
    {
        // Only show published courses
        if ($course->status !== 'published') {
            abort(404, 'Course not found or not available');
        }

        // Get all lessons for this course
        $lessons = $course->lessons()->orderBy('sort_order')->get();
        
        // Handle different lesson parameters
        $lessonParam = $request->get('lesson');
        $currentLesson = null;
        $currentLessonIndex = 0;

        if ($lessonParam === 'complete') {
            // Show completion page
            $currentLesson = null;
            $currentLessonIndex = $lessons->count(); // Set to beyond last lesson
        } elseif (is_numeric($lessonParam)) {
            // Show specific lesson by index
            $lessonIndex = (int) $lessonParam;
            if ($lessonIndex >= 0 && $lessonIndex < $lessons->count()) {
                $currentLesson = $lessons[$lessonIndex];
                $currentLessonIndex = $lessonIndex;
            } else {
                // Invalid lesson index, redirect to first lesson
                return redirect()->route('courses.preview', ['course' => $course, 'lesson' => 0]);
            }
        } else {
            // Default to first lesson if no valid lesson specified
            if ($lessons->count() > 0) {
                $currentLesson = $lessons[0];
                $currentLessonIndex = 0;
            } else {
                // No lessons available
                $currentLesson = null;
                $currentLessonIndex = 0;
            }
        }

        return view('course-preview', compact(
            'course',
            'lessons',
            'currentLesson',
            'currentLessonIndex'
        ));
    }

    // Other public methods can be added here
    public function primary()
    {
        $courses = Course::where('category', 'primary')
            ->where('status', 'published')
            ->with('lessons')
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('class'), function ($query) {
                $query->where('class_level', request('class'));
            })
            ->paginate(12);

        $availableClasses = Course::where('category', 'primary')
            ->where('status', 'published')
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('primary', compact('courses', 'availableClasses'));
    }

    public function secondary()
    {
        $courses = Course::where('category', 'secondary')
            ->where('status', 'published')
            ->with('lessons')
            ->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('form'), function ($query) {
                $query->where('class_level', request('form'));
            })
            ->paginate(12);

        $availableForms = Course::where('category', 'secondary')
            ->where('status', 'published')
            ->distinct()
            ->pluck('class_level')
            ->filter()
            ->sort();

        return view('secondary', compact('courses', 'availableForms'));
    }

    

    public function home()
{
    // Get latest 6 courses for the "Latest Courses" section
    $latestCourses = Course::where('status', 'published')
        ->with('lessons')
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

    return view('welcome', compact('latestCourses'));
}

    public function mental()
    {
        return view('mental');
    }

    public function aboutUs()
    {
        return view('about-us');
    }

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        return view('contact');
    }
}