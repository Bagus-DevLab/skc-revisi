<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function stats() {
        $user = auth()->user();
        return response()->json([
            'user_name' => $user->name,
            'active_courses' => $user->courses()->wherePivot('status', 'active')->count(),
            'finished_courses' => $user->courses()->wherePivot('status', 'finished')->count(),
            'total_investment' => $user->courses()->sum('price'),
            'last_course' => $user->courses()->orderByPivot('last_accessed_at', 'desc')->first(),
        ]);
    }
}   