<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Nueva ruta para editar el perfil
    Route::get('profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // (Opcional) Ruta para actualizar el perfil
    Route::put('profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Ruta para eliminar el perfil (si es que quieres permitirlo)
    Route::delete('profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Ruta para ver el listado de registros y el formulario de check-in/check-out.
    Route::get('/work-logs', [WorkLogController::class, 'index'])->name('work_logs.index');

    // Ruta para registrar la entrada (check-in)
    Route::post('/work-logs/check-in', [WorkLogController::class, 'checkIn'])->name('work_logs.check_in');
    
    // Ruta para registrar la salida (check-out)
    Route::post('/work-logs/check-out', [WorkLogController::class, 'checkOut'])->name('work_logs.check_out');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
});

require __DIR__.'/auth.php';
