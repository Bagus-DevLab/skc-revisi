<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

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
        // Ambil data asli
        $courses = Course::latest()->get();
        $totalUsers = User::where('role', 'user')->count();
        $totalCourses = Course::count();
        
        // Ambil 5 user terbaru yang baru mendaftar
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();

        // Placeholder untuk Payment (nanti diisi jika tabel payment sudah ada)
        $pendingPaymentsCount = 0; 
        $totalRevenue = 0;

        return view('admin.dashboard', compact(
            'courses', 
            'totalUsers', 
            'totalCourses', 
            'recentUsers',
            'pendingPaymentsCount',
            'totalRevenue'
        ));
    }
}
