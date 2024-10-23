<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return redirect()->route('login');
});


// Display login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');


// Handle login POST request
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Grouping routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Admin dashboard route
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Teacher dashboard route
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    // Student dashboard route
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
