<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();

        $activeCoursesCount = $user->courses()
            ->wherePivot('status', 'active')
            ->count();

        $finishedCoursesCount = $user->courses()
            ->wherePivot('status', 'finished')
            ->count();

        $totalInvestment = Payment::where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('amount');

        // --- 3. DATA ASLI: KURSUS TERAKHIR DIBUKA ---
        // Mengambil kursus yang paling baru di-update progress-nya
        $lastCourse = $user->courses()
            ->withPivot('progress', 'status', 'updated_at') // Pastikan field ini terambil
            ->orderByPivot('updated_at', 'desc')
            ->first();

        // --- 4. DATA ASLI: LIST KURSUS TERBARU ---
        $recentCourses = $user->courses()
            ->withPivot('progress', 'status', 'updated_at')
            ->orderByPivot('updated_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'thumbnail' => $course->image ? asset('storage/' . $course->image) : 'https://via.placeholder.com/150',
                    'instructor' => $course->instructor ?? 'Admin',
                    'progress' => $course->pivot->progress ?? 0,
                    'category' => $course->category ?? 'General',
                    'image_url' => $course->image,
                ];
            });

        // Return JSON ke Flutter
        return response()->json([
            'stats' => [
                'active_courses' => $activeCoursesCount,
                'finished_courses' => $finishedCoursesCount,
                'total_investment' => $totalInvestment,
            ],
            // Format data last_course agar aman jika null
            'last_course' => $lastCourse ? [
                'id' => $lastCourse->id,
                'title' => $lastCourse->title,
                'category' => $lastCourse->category,
                'image' => $lastCourse->image ? asset('storage/' . $lastCourse->image) : 'https://via.placeholder.com/150',
                'progress' => $lastCourse->pivot->progress ?? 0,
            ] : null,
            'recent_courses' => $recentCourses,
        ]);
    }
}
