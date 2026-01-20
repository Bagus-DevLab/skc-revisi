<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function learn(Course $course)
    {
        // Pastikan user sudah enroll di kursus ini
        if (!auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum terdaftar di kursus ini.');
        }

        // Ambil data enrollment user
        $enrollment = auth()->user()->courses()
            ->where('course_id', $course->id)
            ->first();

        return view('courses.learn', compact('course', 'enrollment'));
    }

        public function completeLesson(Course $course)
    {
        $user = auth()->user();
        
        // Pastikan user sudah enroll
        $enrollment = $user->courses()->where('course_id', $course->id)->first();
        
        if (!$enrollment) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum terdaftar di kursus ini.');
        }
        
        // Update progress (tambah 10% setiap kali complete lesson)
        $currentProgress = $enrollment->pivot->progress;
        $newProgress = min($currentProgress + 10, 100); // Maksimal 100%
        
        // Update status jadi finished kalau sudah 100%
        $status = $newProgress >= 100 ? 'finished' : 'active';
        
        $user->courses()->updateExistingPivot($course->id, [
            'progress' => $newProgress,
            'status' => $status
        ]);
        
        // Redirect dengan pesan sukses
        if ($newProgress >= 100) {
            return redirect()->route('course.learn', $course->id)
                ->with('success', '🎉 Selamat! Anda telah menyelesaikan kursus ini. Sertifikat sudah tersedia!');
        }
        
        return redirect()->route('course.learn', $course->id)
            ->with('success', '✅ Materi berhasil diselesaikan! Progress: ' . $newProgress . '%');
    }
}