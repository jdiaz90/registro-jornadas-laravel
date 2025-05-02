<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/work-logs', [WorkLogController::class, 'index'])->name('work_logs.index');
    Route::post('/check-in', [WorkLogController::class, 'checkIn'])->name('work_logs.check_in');
    Route::post('/check-out', [WorkLogController::class, 'checkOut'])->name('work_logs.check_out');
});

require __DIR__.'/auth.php';
