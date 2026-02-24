<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

// Halaman Login (Hanya bisa diakses jika belum login/guest)
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// Halaman yang butuh Login (Auth)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/user/store', [AdminController::class, 'createUser'])->name('admin.user.store');
    Route::post('/admin/location/store', [AdminController::class, 'addLocation'])->name('admin.location.store');
    Route::post('/admin/shift/store', [AdminController::class, 'addShift'])->name('admin.shift.store');
    Route::post('/admin/group/store', [AdminController::class, 'createGroup'])->name('admin.group.store');

    // PGA
    Route::get('/pga/dashboard', function () {
        return "Selamat Datang PGA!"; // Ganti dengan view dashboard pga Anda
    })->name('pga.dashboard');

    // Dashboard Satpam
    Route::get('/satpam/dashboard', function () {
        return "Selamat Datang Satpam!"; // Ganti dengan view dashboard satpam Anda
    })->name('satpam.dashboard');
});