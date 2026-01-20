<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserProfileController;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/courses', [CourseController::class, 'index']); // List kursus di landing
Route::get('/courses/{id}', [CourseController::class, 'show']); // Detail kursus

// Protected Routes (Harus pakai Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/update-profile', [UserProfileController::class, 'update']);
    Route::post('/user/avatar', [UserProfileController::class, 'updateAvatar']); // Upload/update user avatar
    
    // Dashboard & My Courses
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);
    Route::get('/my-courses', [CourseController::class, 'myCourses']);
    Route::get('/my-certificates', [CourseController::class, 'myCertificates']);
    Route::get('/courses/{course_id}/lessons', [CourseController::class, 'lessons']); // Get lessons for a course
    Route::post('/lessons/{lesson_id}/complete', [CourseController::class, 'completeLesson']); // Mark lesson as complete
    
    // Payment
    Route::post('/checkout/{id}', [PaymentController::class, 'checkout']);
    Route::post('/payment/upload/{id}', [PaymentController::class, 'uploadProof']);
    Route::get('/payment-history', [PaymentController::class, 'history']); // User's payment history
    
    // Notepad (CRUD)
    Route::apiResource('notes', NoteController::class);
    // The previous line already creates a DELETE route for notes.
    // Route::delete('notes/{id}', [NoteController::class, 'destroy']); // This line is redundant if using apiResource
    
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/payments', [App\Http\Controllers\Api\Admin\PaymentController::class, 'index']);
        Route::post('/payments/{id}/approve', [App\Http\Controllers\Api\Admin\PaymentController::class, 'approve']);
        Route::post('/payments/{id}/reject', [App\Http\Controllers\Api\Admin\PaymentController::class, 'reject']);
    });
});