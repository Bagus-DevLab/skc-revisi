<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Payment; // Aktifkan ini jika model Payment sudah dibuat

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();

        // --- 1. DATA ASLI: STATISTIK KURSUS ---
        // Mengambil data real dari tabel pivot 'course_user'
        // Pastikan tabel course_user punya kolom 'status' (active/finished)
        
        $activeCoursesCount = $user->courses()
            ->wherePivot('status', 'active') 
            ->count();

        $finishedCoursesCount = $user->courses()
            ->wherePivot('status', 'finished')
            ->count();

        // --- 2. DATA ASLI: TOTAL INVESTASI ---
        // Mengambil data dari tabel 'payments'
        // Saya pakai pengecekan 'class_exists' agar Backend TIDAK CRASH (Error 500)
        // jika kamu belum membuat Model Payment.
        
        $totalInvestment = 0;
        
        if (class_exists(\App\Models\Payment::class)) {
            // Jika Model Payment ada, hitung totalnya
            $totalInvestment = \App\Models\Payment::where('user_id', $user->id)
                ->where('status', 'paid')
                ->sum('amount');
        }

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
                    // Gunakan storage URL jika ada gambar, atau placeholder jika null
                    'thumbnail' => $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/150',
                    'instructor' => $course->instructor ?? 'Admin',
                    'progress' => $course->pivot->progress ?? 0,
                    'category' => $course->category ?? 'General',
                    'image_url' => $course->thumbnail, // Alias untuk Flutter
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
                'image' => $lastCourse->thumbnail ? asset('storage/' . $lastCourse->thumbnail) : 'https://via.placeholder.com/150',
                'progress' => $lastCourse->pivot->progress ?? 0,
            ] : null,
            'recent_courses' => $recentCourses,
        ]);
    }
}