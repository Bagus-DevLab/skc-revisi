<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\RespondsWithApiJson;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use RespondsWithApiJson;

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
                    'thumbnail' => $course->image ? asset('storage/'.$course->image) : null,
                    'instructor' => $course->instructor ?? 'Admin',
                    'progress' => $course->pivot->progress ?? 0,
                    'category' => $course->category ?? 'General',
                    'image' => $course->image,
                    'image_url' => $course->image ? asset('storage/'.$course->image) : null,
                ];
            });

        return $this->success([
            'stats' => [
                'active_courses' => $activeCoursesCount,
                'finished_courses' => $finishedCoursesCount,
                'total_investment' => $totalInvestment,
            ],
            'last_course' => $lastCourse ? [
                'id' => $lastCourse->id,
                'title' => $lastCourse->title,
                'category' => $lastCourse->category,
                'image' => $lastCourse->image,
                'image_url' => $lastCourse->image ? asset('storage/'.$lastCourse->image) : null,
                'progress' => $lastCourse->pivot->progress ?? 0,
            ] : null,
            'recent_courses' => $recentCourses,
        ]);
    }
}
