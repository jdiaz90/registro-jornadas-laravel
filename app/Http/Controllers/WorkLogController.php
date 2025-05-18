<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\WorkLog;
use App\Models\WorkLogAudit;
use App\Models\User;
use App\Exports\YearlyWorkLogsExport;
use App\Http\Requests\UpdateWorkLogRequest;
use Maatwebsite\Excel\Facades\Excel;
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
        $logs = $query->orderBy('check_in', 'desc')
                      ->paginate(30)
                      ->withQueryString();

        return view('work_logs.index', compact('logs'));
    }

    public function adminIndex(Request $request)
    {
        // Validar la solicitud asegurando que, si se ingresa una fecha, se ingrese ambas
        $validated = $request->validate([
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date'   => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
            'user'       => ['nullable', 'exists:users,id'],
        ], [
            'end_date.after_or_equal' => __('work_logs.messages.invalid_date_range'),
            'start_date.required_with' => __('work_logs.messages.required_date_pair'),
            'end_date.required_with'   => __('work_logs.messages.required_date_pair'),
        ]);

        // Verificar que el usuario autenticado es administrador
        if (Auth::user()->role !== 'admin') {
            abort(403, __('work_logs.messages.authorization.unauthorized'));
        }

        // Construir la consulta de Work Logs
        $query = WorkLog::query();

        // Filtrar por rango de fechas si se proporcionan ambas
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($validated['start_date'])->startOfDay();
            $endDate   = Carbon::parse($validated['end_date'])->endOfDay();

            $query->whereBetween('check_in', [$startDate, $endDate]);
        }

        // Filtrar por usuario si se proporciona
        if ($request->filled('user')) {
            $query->where('user_id', $validated['user']);
        }

        // Obtener los registros ordenados por check-in descendente
        $logs = $query->orderBy('check_in', 'desc')
                    ->paginate(30)
                    ->withQueryString();

        // Obtener la lista de usuarios para el filtro
        $users = User::orderBy('name')->get();

        return view('admin.work_logs.index', compact('logs', 'users'));
    }

 

    // Registrar la entrada
    public function checkIn(Request $request)
    {
        $userId = Auth::id();
    
        // Verificamos que el usuario no tenga un registro abierto (sin check‑out)
        $openLog = WorkLog::where('user_id', $userId)
            ->whereNull('check_out')
            ->first();
    
        if ($openLog) {
            return back()->with('error', __('work_logs.messages.check_in.already_open'));
        }
    
        // Verificamos que no exista ya un registro para el día de hoy (comparando solo la fecha)
        $todayRegister = WorkLog::where('user_id', $userId)
            ->whereDate('check_in', Carbon::today())
            ->first();
    
        if ($todayRegister) {
            return back()->with('error', __('work_logs.messages.check_in.already_today'));
        }
    
        // Si pasa ambas validaciones, creamos el registro de entrada.
        WorkLog::create([
            'user_id'  => $userId,
            'check_in' => Carbon::now(),
        ]);
    
        return back()->with('success', __('work_logs.messages.check_in.success'));
    }

    // Registrar la salida
    public function checkOut(Request $request)
    {
        // Encontrar el registro en curso y cargar 'user.workSchedule'
        $log = WorkLog::with('user.workSchedule')
            ->where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();
    
        if (!$log) {
            return back()->with('error', __('work_logs.messages.check_out.no_open'));
        }
    
        // Si existe una pausa iniciada sin finalizar, finalízala automáticamente.
        if ($log->pause_start && is_null($log->pause_end)) {
            $log->pause_end = Carbon::now();
            $log->pause_minutes = $log->pause_end->diffInMinutes($log->pause_start);
        }
    
        // Registrar la salida
        $log->check_out = Carbon::now();
    
        // Recalcula las horas y guarda el registro
        if (!$log->calculateHours()) {
            return back()->with('error', __('work_logs.messages.hours_calculation_error'));
        }
    
        return back()->with('success', __('work_logs.messages.check_out.success'));
    }

    // Nuevo método: Iniciar Pausa
    public function pauseStart(Request $request)
    {
        $userId = Auth::id();

        // Buscar el registro abierto para el usuario (donde 'check_out' es nulo)
        $workLog = WorkLog::where('user_id', $userId)
            ->whereNull('check_out')
            ->latest('check_in')
            ->first();

        if (!$workLog) {
            return back()->with('error', __('work_logs.messages.pause.start.no_active_log'));
        }

        // Si ya se ha registrado una pausa (independientemente de si se finalizó o no),
        // no se permite iniciar otra pausa.
        if (!is_null($workLog->pause_start)) {
            return back()->with('error', __('work_logs.messages.pause.start.already_started'));
        }

        // Iniciar la pausa estableciendo la hora actual en 'pause_start'
        $workLog->pause_start = Carbon::now();
        $workLog->save();

        return back()->with('success', __('work_logs.messages.pause.start.success'));
    }

    // Nuevo método: Finalizar Pausa
    public function pauseEnd(Request $request)
    {
        // Buscar el registro abierto del usuario.
        $log = WorkLog::where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();

        if (!$log) {
            return back()->with('error', __('work_logs.messages.pause.end.no_active_log'));
        }

        // Verifica que ya se haya iniciado una pausa y que no se haya finalizado.
        if (!$log->pause_start || $log->pause_end) {
            return back()->with('error', __('work_logs.messages.pause.end.not_started'));
        }

        // Registrar el final de la pausa.
        $log->pause_end = Carbon::now();
        $log->pause_minutes = (int)$log->pause_end->diffInMinutes($log->pause_start);
        $log->save();

        return back()->with('success', __('work_logs.messages.pause.end.success'));
    }

    // Muestra el formulario para que el administrador edite el registro.
    public function edit($id)
    {
        $workLog = WorkLog::findOrFail($id);
        return view('work_logs.edit', compact('workLog'));
    }

    // Mostrar detalle de un registro
    public function show($id)
    {
        // Obtenemos el registro junto con la relación "user".
        $workLog = WorkLog::with('user')->findOrFail($id);
    
        // Si el usuario autenticado no es admin y además no es el dueño del registro, lanzamos error 403.
        if (Auth::user()->role !== 'admin' && Auth::id() !== $workLog->user_id) {
            abort(403, __('work_logs.messages.authorization.unauthorized'));
        }
    
        $audits = WorkLogAudit::where('work_log_id', $workLog->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('work_logs.show', compact('workLog', 'audits'));
    }
    
    // Procesa la actualización realizada por el administrador.
    public function update(UpdateWorkLogRequest $request, $id)
    {
        // Se obtienen los datos validados.
        $validated = $request->validated();
        
        // Buscamos el registro.
        $workLog = WorkLog::findOrFail($id);

        // Si los datos que llegan son idénticos a los existentes, se informa sin proceder a actualizar.
        if (!$workLog->hasDataChanges($validated)) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', __('work_logs.messages.update.no_changes'));
        }

        // Extraemos el motivo de modificación.
        $modificationReason = $validated['modification_reason'];
        // Eliminamos esa llave del array para actualizar el registro.
        $data = $validated;
        unset($data['modification_reason']);

        // Actualizamos el modelo con los datos validados.
        $workLog->fill($data);
        // Asignamos el motivo en una propiedad temporal (para auditoría o registro).
        $workLog->temp_modification_reason = $modificationReason;

        // Llamamos explícitamente a calculateHours() para actualizar los campos de horas y guardar el registro.
        if (!$workLog->calculateHours()) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', __('work_logs.messages.hours_calculation_error'));
        }

        // Retornamos a la vista de detalle con un mensaje de éxito.
        return redirect()->route('work_logs.show', $workLog->id)
            ->with('success', __('work_logs.messages.update.success'));
    }

    // Método para descargar reporte anual.
    public function exportYearlyReport($year)
    {
        return Excel::download(new YearlyWorkLogsExport($year), 'work_logs_' . $year . '.xlsx');
    }
}
