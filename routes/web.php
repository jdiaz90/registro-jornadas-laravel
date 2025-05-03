<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WorkLogAuditController;
use App\Http\Controllers\WorkLogVerificationController;

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
    
    // Rutas de usuarios estándar para Work Logs y Calendario
    Route::group([], function () {
        Route::get('/work-logs', [WorkLogController::class, 'index'])->name('work_logs.index');
        Route::post('/work-logs/check-in', [WorkLogController::class, 'checkIn'])->name('work_logs.check_in');
        Route::post('/work-logs/check-out', [WorkLogController::class, 'checkOut'])->name('work_logs.check_out');
        Route::get('/work-logs/{workLog}', [WorkLogController::class, 'show'])->name('work_logs.show');
        Route::get('/work-logs/export/{year}', [WorkLogController::class, 'exportYearlyReport'])->name('worklogs.export.yearly');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        
        // Rutas para verificar la autenticidad de un registro WorkLog.
        // Usamos una URL completamente distinta para evitar conflictos con la ruta /work-logs/{workLog}.
        Route::get('/verify-worklog', [WorkLogVerificationController::class, 'showForm'])->name('work_logs.verify');
        Route::post('/verify-worklog', [WorkLogVerificationController::class, 'verify'])->name('work_logs.verify.process');
    });
    
    // Rutas de administración (solo para administradores)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard y gestión de usuarios
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
        
        // Rutas para editar y actualizar Work Logs
        Route::get('/work-logs/{work_log}/edit', [WorkLogController::class, 'edit'])->name('work_logs.edit');
        Route::put('/work-logs/{work_log}', [WorkLogController::class, 'update'])->name('work_logs.update');
        
        // Auditoría de Work Logs (solo index y show)
        Route::resource('work_log_audits', WorkLogAuditController::class)
             ->only(['index', 'show']);
    });
});

require __DIR__.'/auth.php';
