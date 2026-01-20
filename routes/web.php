<?php

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
        return view('dashboard');
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
            return view('admin.dashboard');
        })->name('dashboard'); // Ini jadinya admin.dashboard
        
        // Tambahkan route khusus admin lainnya disini
    });

});