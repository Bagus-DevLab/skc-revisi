<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        
        // 1. Ambil Kursus yang diikuti user
        $enrollments = $user->courses; 

        // 2. Statistik
        $activeCoursesCount = $user->courses()->wherePivot('status', 'active')->count();
        $finishedCoursesCount = $user->courses()->wherePivot('status', 'finished')->count();
        $totalInvestment = $user->courses()->sum('price');

        // 3. Ambil 1 Kursus Terakhir yang diakses (untuk banner utama)
        $lastCourse = $user->courses()
                           ->orderByPivot('last_accessed_at', 'desc')
                           ->first();

        return view('dashboard', compact(
            'activeCoursesCount', 
            'finishedCoursesCount', 
            'totalInvestment', 
            'lastCourse'
        ));
    }
}
