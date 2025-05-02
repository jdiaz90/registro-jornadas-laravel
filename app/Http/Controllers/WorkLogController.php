<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\WorkLog;
use Illuminate\Support\Facades\Auth;

class WorkLogController extends Controller
{
    // Mostrar el estado actual del usuario o los registros anteriores
    public function index(Request $request)
{
    // Inicia la consulta para el usuario autenticado.
    $query = WorkLog::where('user_id', Auth::id());

    // Si se ingresa un año, filtra por ese año
    if ($request->filled('year')) {
        $query->whereYear('check_in', $request->year);
        
        // Si adicionalmente se ha seleccionado un mes, filtra por ese mes
        if ($request->filled('month')) {
            $query->whereMonth('check_in', $request->month);
        }
    }

    // Ordena por fecha de creación descendente y aplica la paginación
    $logs = $query->orderBy('created_at', 'desc')
                ->paginate(30)
                ->withQueryString();

    return view('work_logs.index', compact('logs'));
}

    

    // Registrar la entrada
    public function checkIn(Request $request)
    {
        // Verificamos que el usuario no tenga un registro en curso
        $openLog = WorkLog::where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();

        if ($openLog) {
            return back()->with('error', 'Ya has registrado una entrada y no has completado la salida.');
        }

        WorkLog::create([
            'user_id'  => Auth::id(),
            'check_in' => Carbon::now(),
        ]);

        return back()->with('success', 'Entrada registrada correctamente.');
    }

    // Registrar la salida
    public function checkOut(Request $request)
    {
        // Encontrar el registro en curso
        $log = WorkLog::where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();

        if (!$log) {
            return back()->with('error', 'No existe un registro de entrada abierta.');
        }

        $log->update([
            'check_out' => Carbon::now(),
        ]);

        return back()->with('success', 'Salida registrada correctamente.');
    }
}
