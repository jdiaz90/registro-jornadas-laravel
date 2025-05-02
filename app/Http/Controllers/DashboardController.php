<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkLog;

class DashboardController extends Controller
{
    public function index()
    {
        // Consultamos la cantidad de Work Logs registrados para el usuario autenticado
        $logCount = WorkLog::where('user_id', Auth::id())->count();

        // Retornamos la vista 'dashboard' pasando la variable $logCount
        return view('dashboard', compact('logCount'));
    }
}
