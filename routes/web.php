<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Work Logs y Calendario
    Route::group([], function () {
        Route::get('/work-logs', [WorkLogController::class, 'index'])->name('work_logs.index');
        Route::post('/work-logs/check-in', [WorkLogController::class, 'checkIn'])->name('work_logs.check_in');
        Route::post('/work-logs/check-out', [WorkLogController::class, 'checkOut'])->name('work_logs.check_out');
        Route::get('/work-logs/export/{year}', [WorkLogController::class, 'exportYearlyReport'])->name('worklogs.export.yearly');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    });

    // Rutas de administración (solo para administradores)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        // Ruta para ver la ficha de un usuario (route‑model binding)
        Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
    });
});

require __DIR__.'/auth.php';
