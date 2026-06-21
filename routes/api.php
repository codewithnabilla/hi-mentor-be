<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// public routes

Route::post('/login', [AuthController::class, 'login']);

// protected routes

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
