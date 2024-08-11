<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'index']);
Route::get('/user_data/{id}', [AuthController::class, 'getbyID']);
Route::post('/send_verified_mail/{email}', [AuthController::class, 'sendVerifyMail']);
Route::post('/send-notification', [AuthController::class, 'sendNotification']);
// Consultation routes
use App\Http\Controllers\ConsultationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/consultations', [ConsultationController::class, 'index']);
    Route::get('/consultations/{id}', [ConsultationController::class, 'show']); // Add this line
    Route::post('/consultations/store', [ConsultationController::class, 'store']);
    Route::put('/consultations/{id}', [ConsultationController::class, 'update']);
    Route::delete('/consultations/{id}', [ConsultationController::class, 'destroy']);
});
