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

// Protected Routes (Harus pakai Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/update-profile', [UserProfileController::class, 'update']);
    
    // Dashboard & My Courses
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);
    Route::get('/my-courses', [CourseController::class, 'myCourses']);
    Route::get('/my-certificates', [CourseController::class, 'myCertificates']);
    
    // Payment
    Route::post('/checkout/{id}', [PaymentController::class, 'checkout']);
    Route::post('/payment/upload/{id}', [PaymentController::class, 'uploadProof']);
    
    // Notepad (CRUD)
    Route::apiResource('notes', NoteController::class);
    Route::delete('notes/{id}', [NoteController::class, 'destroy']);
});