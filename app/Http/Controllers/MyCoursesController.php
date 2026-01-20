<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCoursesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        // Ganti tanda titik (.) sebelum get() menjadi panah (->)
        $enrollments = $user->courses()->withPivot('progress', 'status')->get();

        // Hitung statistik untuk header
        $totalCourses = $enrollments->count();
        $ongoingCount = $enrollments->where('pivot.status', 'active')->count();
        $finishedCount = $enrollments->where('pivot.status', 'finished')->count();

        return view('my-courses', compact('enrollments', 'totalCourses', 'ongoingCount', 'finishedCount'));
    }
}
