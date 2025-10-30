<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;

// ADMIN LOGIN ROUTES
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.page');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// USER LOGIN ROUTES
Route::get('/user/login', [UserLoginController::class, 'showLoginForm'])->name('user.login.page');
Route::post('/user/login', [UserLoginController::class, 'login'])->name('user.login');

// DASHBOARD ROUTES
Route::get('/admin/dashboard', function () {
    return view('dashboard.index');  // make sure this file exists
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// User Dashboard
Route::get('/user/dashboard', function () {
    return view('dashboard.user_dashboard');
})->middleware(['auth', 'role:user'])->name('user.dashboard');
// Logout
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::get('/', function () {
    return view('welcome');
});
