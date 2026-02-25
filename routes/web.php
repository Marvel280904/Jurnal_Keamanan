<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationShiftController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\GroupManagementController;
use App\Http\Controllers\SystemLogController;

// Halaman Login (Hanya bisa diakses jika belum login/guest)
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

// Halaman yang butuh Login (Auth)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin - Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin - System Logs
    Route::get('/admin/system-logs', [SystemLogController::class, 'index'])->name('admin.system-logs');

    // Admin - User Management
    Route::get('/admin/user-management', [UserManagementController::class, 'index'])->name('admin.user-management');
    Route::post('/admin/user', [UserManagementController::class, 'addUser'])->name('admin.user.store');
    Route::put('/admin/user/{user}', [UserManagementController::class, 'editUser'])->name('admin.user.update');
    Route::delete('/admin/user/{user}', [UserManagementController::class, 'deleteUser'])->name('admin.user.destroy');

    // Admin - Group Management
    Route::get('/admin/group-management', [GroupManagementController::class, 'index'])->name('admin.group-management');
    Route::post('/admin/group', [GroupManagementController::class, 'addGroup'])->name('admin.group.store');
    Route::put('/admin/group/{group}', [GroupManagementController::class, 'editGroup'])->name('admin.group.update');
    Route::delete('/admin/group/{group}', [GroupManagementController::class, 'deleteGroup'])->name('admin.group.destroy');

    // Admin - Location & Shift Management
    Route::get('/admin/location-shift', [LocationShiftController::class, 'index'])->name('admin.location-shift');

    // Locations
    Route::post('/admin/location', [LocationShiftController::class, 'addLocation'])->name('admin.location.store');
    Route::put('/admin/location/{location}', [LocationShiftController::class, 'editLocation'])->name('admin.location.update');
    Route::patch('/admin/location/{location}/toggle', [LocationShiftController::class, 'updateLocationStatus'])->name('admin.location.toggle');
    Route::delete('/admin/location/{location}', [LocationShiftController::class, 'deleteLocation'])->name('admin.location.destroy');

    // Shifts
    Route::post('/admin/shift', [LocationShiftController::class, 'addShift'])->name('admin.shift.store');
    Route::put('/admin/shift/{shift}', [LocationShiftController::class, 'editShift'])->name('admin.shift.update');
    Route::patch('/admin/shift/{shift}/toggle', [LocationShiftController::class, 'updateShiftStatus'])->name('admin.shift.toggle');
    Route::delete('/admin/shift/{shift}', [LocationShiftController::class, 'deleteShift'])->name('admin.shift.destroy');

    // PGA
    Route::get('/pga/dashboard', function () {
        return "Selamat Datang PGA!"; // Ganti dengan view dashboard pga Anda
    })->name('pga.dashboard');

    // Dashboard Satpam
    Route::get('/satpam/dashboard', function () {
        return "Selamat Datang Satpam!"; // Ganti dengan view dashboard satpam Anda
    })->name('satpam.dashboard');
});