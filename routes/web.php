<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\MedicineCategoryController;
use App\Http\Controllers\MedicineController;

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

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {

    // ============================
    // 📦 CATEGORY ROUTES
    // ============================
    Route::get('/categories', [MedicineCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [MedicineCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [MedicineCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [MedicineCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [MedicineCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [MedicineCategoryController::class, 'destroy'])->name('categories.destroy');


    // ============================
    // 💊 MEDICINE ROUTES
    // ============================
    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('/medicines/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
    Route::delete('/medicines/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
});

Route::get('/', function () {
    return view('welcome');
});
