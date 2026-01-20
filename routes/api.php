<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController; // <--- Pastikan Namespace API
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserProfileController;

// --- Public Routes ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/courses', [CourseController::class, 'index']); 
Route::get('/courses/{id}', [CourseController::class, 'show']); // Detail metadata kursus (opsional)

// --- Protected Routes (Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    // User & Profile
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/update-profile', [UserProfileController::class, 'update']);
    Route::post('/user/avatar', [UserProfileController::class, 'updateAvatar']);

    // Dashboard & Courses
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);
    Route::get('/my-courses', [CourseController::class, 'myCourses']);
    Route::get('/my-certificates', [CourseController::class, 'myCertificates']);
    
    // DETAIL KURSUS & PROGRESS (Penting buat Step 15)
    Route::get('/courses/{id}/lessons', [CourseController::class, 'lessons']); 
    
    // Perbaikan Route Progress: Pakai ID Kursus
    Route::post('/courses/{id}/progress', [CourseController::class, 'completeLesson']); 

    // Payment
    Route::post('/checkout/{id}', [PaymentController::class, 'checkout']);
    Route::post('/payment/upload/{id}', [PaymentController::class, 'uploadProof']);
    Route::get('/payment-history', [PaymentController::class, 'history']);

    // Notes (CRUD) - Sudah Oke
    Route::apiResource('notes', NoteController::class);

    // Admin Routes - Sudah Oke
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/payments', [App\Http\Controllers\Api\Admin\PaymentController::class, 'index']);
        Route::post('/payments/{id}/approve', [App\Http\Controllers\Api\Admin\PaymentController::class, 'approve']);
        Route::post('/payments/{id}/reject', [App\Http\Controllers\Api\Admin\PaymentController::class, 'reject']);
    });
});