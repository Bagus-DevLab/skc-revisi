<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List kursus untuk landing page Flutter
    public function index() {
        $courses = Course::latest()->get()->map(function($course) {
            $course->image = url('storage/' . $course->image);
            return $course;
        });
        return response()->json($courses);
    }

    // Detail kursus
    public function show($id)
    {
        $course = Course::with('lessons')->findOrFail($id); // Assuming 'lessons' relationship exists
        $course->image = url('storage/' . $course->image);
        return response()->json($course);
    }

    // Kursus yang sudah dibeli user
    public function myCourses() {
        $courses = auth()->user()->courses()->withPivot('progress', 'status')->get()->map(function($course) {
            $course->image = url('storage/' . $course->image);
            return $course;
        });
        return response()->json($courses);
    }

    // Sertifikat (kursus status finished)
    public function myCertificates() {
        $certs = auth()->user()->courses()
                    ->wherePivot('status', 'finished')
                    ->get();
        return response()->json($certs);
    }

    // Get lessons for a specific course
    public function lessons(Request $request, $course_id)
    {
        $user = $request->user();
        // Ensure user is enrolled in the course or has access
        $course = $user->courses()->where('course_id', $course_id)->first(); // Assuming 'courses' relationship on User model

        if (!$course) {
            return response()->json(['message' => 'User not enrolled in this course or course not found.'], 403);
        }

        // Assuming 'lessons' relationship exists on Course model and 'order' column on Lesson model
        $lessons = $course->lessons()->orderBy('order')->get();
        return response()->json($lessons);
    }

    // Mark a lesson as complete
    public function completeLesson(Request $request, $lesson_id)
    {
        // Placeholder for actual lesson completion logic
        // In a real scenario, this would involve:
        // 1. Check if the user is enrolled in the course that contains this lesson.
        // 2. Mark the lesson as completed for the user (e.g., in a pivot table).
        // 3. Update the overall course progress for the user based on completed lessons.
        // 4. Handle cases where the lesson does not exist or user is not authorized.

        return response()->json(['message' => 'Lesson marked as complete (logic to be implemented).']);
    }
}