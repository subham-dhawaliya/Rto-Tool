<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceApplicationController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Track Application (Public - no login required)
Route::get('/track', [ServiceApplicationController::class, 'track'])->name('applications.track');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Applications
    Route::get('/applications', [ServiceApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create/{serviceType}', [ServiceApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ServiceApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [ServiceApplicationController::class, 'show'])->name('applications.show');
    Route::get('/applications/{application}/edit', [ServiceApplicationController::class, 'edit'])->name('applications.edit');
    
    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/book', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});
