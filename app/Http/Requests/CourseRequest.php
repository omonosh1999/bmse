<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function store(CourseRequest $request)
    {
        $validated = $request->validated();
        
        // Add the current user as creator
        $validated['created_by'] = Auth::id();

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $request->file('cover_photo')->store('course-covers', 'public');
        }

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully!');
    }

    public function update(CourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo
            if ($course->cover_photo && Storage::disk('public')->exists($course->cover_photo)) {
                Storage::disk('public')->delete($course->cover_photo);
            }
            
            $validated['cover_photo'] = $request->file('cover_photo')->store('course-covers', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        // Delete cover photo when deleting course
        if ($course->cover_photo && Storage::disk('public')->exists($course->cover_photo)) {
            Storage::disk('public')->delete($course->cover_photo);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}