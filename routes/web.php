<?php
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);

Route::get('/verify', [AuthController::class, 'showVerify']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/logout', [AuthController::class, 'logout']);

// Application Protected Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index']);

// Execute Request Resolution
Route::dispatch();

