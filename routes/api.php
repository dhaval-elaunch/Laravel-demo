<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

// User Authentication Routes
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'logins']); 

Route::middleware(['auth:api', 'role:Admin'])->group(function () {

    // dd(123);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);

    Route::get('/admin/users', [AdminController::class, 'userList']);
    Route::post('/admin/create', [AdminController::class, 'createAdmin']);
    Route::put('/admin/update/{id}', [AdminController::class, 'updateAdmin']);
    Route::get('/admin/users/{id}', [AdminController::class, 'show']);
    Route::get('/admin/roles', [AdminController::class, 'roleList']);
});

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
