<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson; // Pastikan Model Lesson ada, kalau belum ada kita bahas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    // 1. LIST SEMUA KURSUS (Untuk Tab Courses)
    public function index()
    {
        $courses = Course::all();
        // Atau kalau mau filter yg user enroll saja, logika bisa disesuaikan
        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::with('lessons')->find($id);

        if (!$course) {
            return response()->json(['message' => 'Kursus tidak ditemukan'], 404);
        }

        return response()->json($course);
    }

    // 2. DETAIL KURSUS & LIST LESSON (PENTING BUAT FLUTTER)
    public function lessons(Request $request, $course_id)
    {
        // Cari kursus
        $course = Course::find($course_id);
        if (!$course) {
            return response()->json(['message' => 'Kursus tidak ditemukan'], 404);
        }

        // Cek Enrollment User
        $enrollment = $request->user()->courses()
                        ->where('course_id', $course_id)
                        ->first();

        if (!$enrollment) {
            return response()->json(['message' => 'Anda belum terdaftar'], 403);
        }

        return response()->json($course->lessons);
    }

    public function completeLessonByLesson(Request $request, $lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!$lesson) {
            return response()->json(['message' => 'Materi tidak ditemukan'], 404);
        }

        $enrollment = $request->user()->courses()
            ->where('course_id', $lesson->course_id)
            ->first();

        if (!$enrollment) {
            return response()->json(['message' => 'Anda belum terdaftar'], 403);
        }

        return response()->json([
            'message' => 'Lesson marked as complete (logic to be implemented).',
        ]);
    }

    // 3. COMPLETE LESSON (VERSI API)
    public function completeLesson(Request $request, $id)
    {
        $user = $request->user();
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Kursus tidak ditemukan'], 404);
        }
        
        // Cek Enrollment
        $enrollment = $user->courses()->where('course_id', $course->id)->first();
        
        if (!$enrollment) {
            return response()->json(['message' => 'Anda belum terdaftar'], 403);
        }
        
        // LOGIC UPDATE PROGRESS (Copy dari Web Controller kamu)
        $currentProgress = $enrollment->pivot->progress;
        
        // Tambah 10% (Atau logika lain per lesson)
        $newProgress = min($currentProgress + 10, 100); 
        $status = $newProgress >= 100 ? 'finished' : 'active';
        
        $user->courses()->updateExistingPivot($course->id, [
            'progress' => $newProgress,
            'status' => $status
        ]);
        
        return response()->json([
            'message' => 'Progress berhasil diupdate',
            'progress' => $newProgress,
            'status' => $status,
            'is_completed' => $newProgress >= 100
        ]);
    }

    // 4. MY COURSES (List kursus yang diambil user)
    public function myCourses(Request $request)
    {
        $courses = $request->user()->courses()->get();
        return response()->json(['data' => $courses]); // Format sesuai repository Flutter
    }

    public function myCertificates(Request $request)
    {
        $courses = $request->user()->courses()
            ->wherePivot('status', 'finished')
            ->get();

        return response()->json($courses);
    }
}
