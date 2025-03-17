<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard', ['user' => Auth::user()]);
// })->middleware('auth');

Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AuthController::class, 'usersList'])->name('admin.users');
    Route::get('/admin/create', [AuthController::class, 'createUser'])->name('admin.create');
    Route::post('/admin/store', [AuthController::class, 'storeUser'])->name('admin.store');
    Route::get('/admin/edit/{id}', [AuthController::class, 'editUser'])->name('admin.edit');
    Route::post('/admin/update/{id}', [AuthController::class, 'updateUser'])->name('admin.update');
    Route::delete('/admin/delete/{id}', [AuthController::class, 'deleteUser'])->name('admin.delete');
});

Route::middleware(['auth', 'role:Editor'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AuthController::class, 'usersList'])->name('admin.users');
    Route::get('/admin/edit/{id}', [AuthController::class, 'editUser'])->name('admin.edit');
    Route::post('/admin/update/{id}', [AuthController::class, 'updateUser'])->name('admin.update');
});

Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AuthController::class, 'usersList'])->name('admin.users');
});
