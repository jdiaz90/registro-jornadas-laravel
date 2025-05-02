<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Muestra el calendario anual con los registros del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Se obtiene el año a visualizar (por defecto el año actual)
        $year = $request->input('year', date('Y'));
        
        // Obtener los registros del usuario para el año indicado
        // y agruparlos por fecha (formato 'Y-m-d')
        $logs = WorkLog::where('user_id', Auth::id())
                ->whereYear('check_in', $year)
                ->get()
                ->groupBy(function($log) {
                    return Carbon::parse($log->check_in)->format('Y-m-d');
                });
                
        return view('calendar.index', compact('year', 'logs'));
    }
}
