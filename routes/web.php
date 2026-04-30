<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;

use App\Http\Controllers\AdminBookingController;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.session'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings');
    Route::get('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/passengers', [\App\Http\Controllers\AdminPassengerController::class, 'index'])->name('admin.passengers');
    Route::get('/admin/schedules', [\App\Http\Controllers\AdminScheduleController::class, 'index'])->name('admin.schedules');
    Route::post('/admin/schedules', [\App\Http\Controllers\AdminScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::delete('/admin/schedules/{id}', [\App\Http\Controllers\AdminScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
    Route::get('/admin/fleet', [\App\Http\Controllers\AdminFleetController::class, 'index'])->name('admin.fleet');
    Route::post('/admin/fleet', [\App\Http\Controllers\AdminFleetController::class, 'store'])->name('admin.fleet.store');
    Route::delete('/admin/fleet/{id}', [\App\Http\Controllers\AdminFleetController::class, 'destroy'])->name('admin.fleet.destroy');
    Route::get('/admin/logs', [\App\Http\Controllers\AdminLogController::class, 'index'])->name('admin.logs');
});
