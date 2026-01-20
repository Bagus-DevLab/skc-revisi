<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyCoursesController;
use App\Http\Controllers\MyCertificatesController;
use App\Http\Controllers\NotepadController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', LandingController::class)->name('landing');

Route::get('/recommendations', [CourseController::class, 'recommend'])->name('course.recommend');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/my-courses', MyCoursesController::class)->name('my-courses');
    Route::get('/my-certificates', MyCertificatesController::class)->name('my-certificates');
    Route::get('/payment-history', [PaymentController::class, 'userHistory'])->name('payment-history');
    Route::get('/notepad', NotepadController::class)->name('notepad');

    Route::get('/course/{course}/learn', [CourseController::class, 'learn'])->name('course.learn');
    Route::post('/course/{course}/complete-lesson', [CourseController::class, 'completeLesson'])->name('course.complete-lesson');
    Route::get('/download-certificate/{course_id}', [CourseController::class, 'downloadCertificate'])->name('certificate.download');
    
    Route::get('/course/{id}/checkout', [PaymentController::class, 'checkout'])->name('course.checkout');
    Route::post('/course/{id}/checkout', [PaymentController::class, 'store'])->name('course.store');
    Route::get('/payment/{id}/upload', [PaymentController::class, 'uploadPage'])->name('payment.upload');
    Route::post('/payment/{id}/upload', [PaymentController::class, 'processUpload'])->name('payment.process');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('courses', AdminCourseController::class);
        Route::resource('users', AdminUserController::class);
        Route::get('/payments', [AdminPaymentController::class, 'indexAdmin'])->name('payments.index');
        Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    });
});