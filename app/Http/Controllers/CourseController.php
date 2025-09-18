<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;

class CourseController extends Controller
{
    /**
     * Display all courses
     */
    public function index()
    {
        $courses = Course::with(['user', 'lessons'])
                        ->where('created_by', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course (Step 1)
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store the basic course information (Step 1) - Enhanced with better error handling
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|in:primary,secondary',
                'class_level' => 'required|string',
                'instructor' => 'required|string|max:255',
                'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $request->only(['title', 'description', 'category', 'class_level', 'instructor']);
            $data['created_by'] = Auth::id();
            $data['status'] = 'draft';

            // Handle cover photo upload with better error handling
            if ($request->hasFile('cover_photo')) {
                $file = $request->file('cover_photo');
                
                // Log file details for debugging
                Log::info('Uploading cover photo', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'storage_path' => storage_path('app/public'),
                    'is_writable' => is_writable(storage_path('app/public')),
                ]);

                // Ensure directory exists
                if (!Storage::disk('public')->exists('course-covers')) {
                    Storage::disk('public')->makeDirectory('course-covers');
                }

                // Store with custom name to avoid conflicts
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('course-covers', $fileName, 'public');
                
                if (!$path) {
                    throw new Exception('Failed to store cover photo');
                }
                
                $data['cover_photo'] = $path;
                
                Log::info('Cover photo uploaded successfully', ['path' => $path]);
            }

            $course = Course::create($data);

            return redirect()->route('courses.curriculum.create', $course)
                            ->with('success', 'Course created successfully! Now add your curriculum.');
                            
        } catch (Exception $e) {
            Log::error('Course creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);
            
            return back()->withInput()
                        ->withErrors(['cover_photo' => 'Failed to upload cover photo: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for adding curriculum (Step 2)
     */
    public function createCurriculum(Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        $lessons = $course->lessons()->orderBy('sort_order')->get();
        
        return view('courses.curriculum', compact('course', 'lessons'));
    }

    /**
     * Store curriculum lessons (Step 2)
     */
    public function storeCurriculum(Request $request, Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'lessons' => 'required|array|min:1',
            'lessons.*.title' => 'required|string|max:255',
            'lessons.*.description' => 'required|string',
            'lessons.*.material_type' => 'required|in:file,url',
            'lessons.*.material_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov,wmv|max:50000',
            'lessons.*.material_url' => 'required_if:lessons.*.material_type,url|url',
        ]);

        // Store existing lesson files to avoid deleting them if not replaced
        $existingLessons = $course->lessons()->get()->keyBy('sort_order');

        // Clear existing lessons
        $course->lessons()->delete();

        foreach ($request->lessons as $index => $lessonData) {
            $data = [
                'course_id' => $course->id,
                'title' => $lessonData['title'],
                'description' => $lessonData['description'],
                'material_type' => $lessonData['material_type'],
                'sort_order' => $index + 1,
            ];

            // Handle file upload or URL
            if ($lessonData['material_type'] === 'file') {
                if (isset($lessonData['material_file']) && $lessonData['material_file']) {
                    // New file uploaded
                    $data['material_path'] = $lessonData['material_file']->store('lesson-materials', 'public');
                } else {
                    // No new file uploaded, check if we have an existing file for this position
                    $existingLesson = $existingLessons->get($index + 1);
                    if ($existingLesson && $existingLesson->material_type === 'file') {
                        $data['material_path'] = $existingLesson->material_path;
                    } else {
                        // This should trigger a validation error, but let's handle gracefully
                        return back()->withErrors(['lessons.' . $index . '.material_file' => 'File is required when material type is file.']);
                    }
                }
            } elseif ($lessonData['material_type'] === 'url') {
                $data['material_path'] = $lessonData['material_url'];
            }

            Lesson::create($data);
        }

        // Auto-publish the course after curriculum is added
        $course->update(['status' => 'published']);

        return redirect()->route('courses.show', $course)
                        ->with('success', 'Curriculum added successfully and course has been published!');
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load(['user', 'lessons']);
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit(Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course - Enhanced with better error handling
     */
    public function update(Request $request, Course $course)
    {
        try {
            // Ensure user owns this course
            if ($course->created_by !== Auth::id()) {
                abort(403);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|in:primary,secondary',
                'class_level' => 'required|string',
                'instructor' => 'required|string|max:255',
                'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $request->only(['title', 'description', 'category', 'class_level', 'instructor']);

            // Handle cover photo upload with better error handling
            if ($request->hasFile('cover_photo')) {
                $file = $request->file('cover_photo');
                
                Log::info('Updating cover photo', [
                    'course_id' => $course->id,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);

                // Delete old cover photo if it exists
                if ($course->cover_photo && Storage::disk('public')->exists($course->cover_photo)) {
                    Storage::disk('public')->delete($course->cover_photo);
                }

                // Ensure directory exists
                if (!Storage::disk('public')->exists('course-covers')) {
                    Storage::disk('public')->makeDirectory('course-covers');
                }

                // Store new photo
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('course-covers', $fileName, 'public');
                
                if (!$path) {
                    throw new Exception('Failed to store cover photo');
                }
                
                $data['cover_photo'] = $path;
            }

            $course->update($data);

            return redirect()->route('courses.show', $course)
                            ->with('success', 'Course updated successfully!');
                            
        } catch (Exception $e) {
            Log::error('Course update failed', [
                'error' => $e->getMessage(),
                'course_id' => $course->id,
                'user_id' => Auth::id(),
            ]);
            
            return back()->withInput()
                        ->withErrors(['cover_photo' => 'Failed to upload cover photo: ' . $e->getMessage()]);
        }
    }

    /**
     * Publish a course
     */
    public function publish(Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        // Ensure course has lessons
        if ($course->lessons()->count() === 0) {
            return back()->with('error', 'Cannot publish course without lessons.');
        }

        $course->update(['status' => 'published']);

        return back()->with('success', 'Course published successfully!');
    }

    /**
     * Unpublish a course
     */
    public function unpublish(Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        $course->update(['status' => 'draft']);

        return back()->with('success', 'Course unpublished successfully!');
    }

    /**
     * Remove the specified course from storage
     */
    public function destroy(Course $course)
    {
        // Ensure user owns this course
        if ($course->created_by !== Auth::id()) {
            abort(403);
        }

        // Delete cover photo
        if ($course->cover_photo) {
            Storage::disk('public')->delete($course->cover_photo);
        }

        // Delete lesson materials
        foreach ($course->lessons as $lesson) {
            if ($lesson->isFile() && $lesson->material_path) {
                Storage::disk('public')->delete($lesson->material_path);
            }
        }

        $course->delete();

        return redirect()->route('courses.index')
                        ->with('success', 'Course deleted successfully!');
    }

    /**
     * Get class options based on category (AJAX)
     */
    public function getClassOptions(Request $request)
    {
        $category = $request->get('category');
        $options = Course::getClassOptions($category);
        
        return response()->json($options);
    }
}