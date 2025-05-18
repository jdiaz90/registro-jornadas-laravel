<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\WorkLogAuditController;
use App\Http\Controllers\WorkLogVerificationController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para cambiar la localización
Route::get('/locale/{locale}', [LocaleController::class, 'change'])->name('locale.change');

// Rutas que requieren autenticación y que ejecuten el middleware "locale"
Route::middleware(['auth', 'locale'])->group(function () {

    // Dashboard del usuario
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil: acciones propias del usuario
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Rutas para Work Logs y Calendario
    Route::get('/work-logs', [WorkLogController::class, 'index'])->name('work_logs.index');
    Route::post('/work-logs/check-in', [WorkLogController::class, 'checkIn'])->name('work_logs.check_in');
    Route::post('/work-logs/check-out', [WorkLogController::class, 'checkOut'])->name('work_logs.check_out');
    Route::get('/work-logs/{workLog}', [WorkLogController::class, 'show'])->name('work_logs.show');
    Route::get('/work-logs/export/{year}', [WorkLogController::class, 'exportYearlyReport'])->name('worklogs.export.yearly');
    
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Rutas para verificar la autenticidad de un WorkLog
    Route::get('/verify-worklog', [WorkLogVerificationController::class, 'showForm'])->name('work_logs.verify');
    Route::post('/verify-worklog', [WorkLogVerificationController::class, 'verify'])->name('work_logs.verify.process');

    // Rutas para iniciar y finalizar pausas
    Route::post('/work-logs/pause-start', [WorkLogController::class, 'pauseStart'])->name('work_logs.pause_start');
    Route::post('/work-logs/pause-end', [WorkLogController::class, 'pauseEnd'])->name('work_logs.pause_end');

    // Rutas de administración (solo para administradores)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard administrativo
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Rutas para la administración de usuarios
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        });

        // Rutas de administración para Work Logs
        Route::get('/work-logs/{work_log}/edit', [WorkLogController::class, 'edit'])->name('work_logs.edit');
        Route::put('/work-logs/{work_log}', [WorkLogController::class, 'update'])->name('work_logs.update');

        // Recurso para Work Log Audits
        Route::resource('work_log_audits', WorkLogAuditController::class)
             ->only(['index', 'show']);
    });
});

require __DIR__ . '/auth.php';
