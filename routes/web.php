<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing Page (Kode kamu yang sebelumnya)
Route::get('/', function () {
    return view('landing');
});

// Logic Redirect Dashboard (Supaya otomatis pisah User/Admin setelah login)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 1. Route Dashboard Umum (Penyortir)
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); // View default Jetstream untuk User
    })->name('dashboard');

    // 2. Route Khusus Admin (Diproteksi Middleware 'role:admin')
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Buat view ini nanti
        })->name('dashboard');
        
        // Tambahkan route admin lain di sini (misal: manage user, laporan, dll)
    });

});
