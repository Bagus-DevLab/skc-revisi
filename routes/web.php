<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// Logic Auth (User yang sudah login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. Route Dashboard Umum
    Route::get('/dashboard', function () {
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
})->name('dashboard');

    // ==========================================
    // 2. ROUTE MENU USER (TARUH DISINI)
    // ==========================================
    // Route ini harus bisa diakses user biasa, jadi taruh diluar grup admin
    
    Route::get('/my-courses', function () { 
        return view('my-courses'); 
    })->name('my-courses');

    Route::get('/my-certificates', function () {
        return view('my-certificates');
    })->name('my-certificates');

    Route::get('/payment-history', function () {
        return view('payment-history');
    })->name('payment-history');

    Route::get('/notepad', function () {
        return view('notepad');
    })->name('notepad');


    // ==========================================
    // 3. ROUTE KHUSUS ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
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
    })->name('dashboard');
            
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
        
        Route::get('/users', function () { return view('admin.users-index'); })->name('users.index');
        Route::get('/payments', function () { return view('admin.payments-index'); })->name('payments.index');
        // Route Kelola User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});