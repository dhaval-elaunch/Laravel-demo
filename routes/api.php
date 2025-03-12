<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

// User Authentication Routes
// Route::post('/register', [AuthController::class, 'register']); 
// Route::post('/login', [AuthController::class, 'login']); 

// Passport authentication route
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
    ->middleware(['throttle', 'guest'])
    ->name('passport.token');

// Role-Based Routes
Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::get('/admin', function () {
        return response()->json(['message' => 'Welcome, Admin']);
    });
});

Route::middleware(['auth:api', 'role:Editor,Admin'])->group(function () {
    Route::get('/editor', function () {
        return response()->json(['message' => 'Welcome, Editor or Admin']);
    });
});

Route::middleware(['auth:api', 'role:User'])->group(function () {
    Route::get('/user', function () {
        return response()->json(['message' => 'Welcome, User']);
    });
});
