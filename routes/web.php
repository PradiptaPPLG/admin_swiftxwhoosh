<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPassengerController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminFleetController;
use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\AdminSecurityController;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.session'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Security & Intruder Alerts (Commonly accessible by both Manager & Admin for security reasons)
    Route::get('/admin/security/intruders', [AdminSecurityController::class, 'index'])->name('admin.security.intruders');
    Route::post('/admin/security/intruders/{id}/resolve', [AdminSecurityController::class, 'resolve'])->name('admin.security.resolve');
    Route::delete('/admin/security/intruders/{id}/delete', [AdminSecurityController::class, 'delete'])->name('admin.security.delete');

    // Manager Specific Routes
    Route::middleware(['role:MANAGER'])->group(function () {
        Route::get('/manager/sales', [DashboardController::class, 'index'])->name('manager.sales');
        Route::get('/manager/passengers', [DashboardController::class, 'index'])->name('manager.passengers');
        Route::get('/manager/performance', [DashboardController::class, 'index'])->name('manager.performance');
    });

    // Admin Only Routes
    Route::middleware(['role:ADMIN'])->group(function () {
        Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings');
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users/{id}/ban', [AdminUserController::class, 'toggleBan'])->name('admin.users.ban');
        Route::post('/admin/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset');
        Route::get('/admin/passengers', [AdminPassengerController::class, 'index'])->name('admin.passengers');
        Route::get('/admin/schedules', [AdminScheduleController::class, 'index'])->name('admin.schedules');
        Route::post('/admin/schedules', [AdminScheduleController::class, 'store'])->name('admin.schedules.store');
        Route::delete('/admin/schedules/{id}', [AdminScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
        Route::get('/admin/fleet', [AdminFleetController::class, 'index'])->name('admin.fleet');
        Route::post('/admin/fleet', [AdminFleetController::class, 'store'])->name('admin.fleet.store');
        Route::delete('/admin/fleet/{id}', [AdminFleetController::class, 'destroy'])->name('admin.fleet.destroy');
        Route::get('/admin/logs', [AdminLogController::class, 'index'])->name('admin.logs');
        Route::get('/admin/failed-transactions', [AdminLogController::class, 'failedTransactions'])->name('admin.failed_transactions');
    });
});
