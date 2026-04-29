<?php

use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Doctor\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

//auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/me', [AuthController::class, 'show'])->middleware('auth:sanctum');

    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

//get all doctors
Route::get('doctors', [DoctorController::class, 'index'])->middleware('auth:sanctum');

//book appointment
Route::post('appointment', [AppointmentController::class, 'store'])->middleware(['auth:sanctum', 'role:user']);

//get my bookings
Route::get('my-bookings', [AppointmentController::class, 'myAppointments'])->middleware(['auth:sanctum', 'role:user']);

//get my schedules
Route::get('my-schedules', [AppointmentController::class, 'mySchedules'])->middleware(['auth:sanctum', 'role:doctor']);
