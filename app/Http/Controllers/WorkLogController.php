<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\WorkLog;
use App\Models\WorkLogAudit;
use App\Exports\YearlyWorkLogsExport;
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

    // Muestra el formulario para que el administrador edite el registro
    public function edit($id)
    {
        $workLog = WorkLog::findOrFail($id);
        return view('work_logs.edit', compact('workLog'));
    }

    public function show($id)
    {
        // Obtenemos el registro junto con la relación "user"
        $workLog = WorkLog::with('user')->findOrFail($id);
    
        // Comprobamos: si el usuario autenticado no es admin (role !== 'admin')
        // y además no es el dueño del registro, lanzamos error 403.
        if (Auth::user()->role !== 'admin' && Auth::id() !== $workLog->user_id) {
            abort(403, 'No está autorizado a ver este registro.');
        }
    
        $audits = WorkLogAudit::where('work_log_id', $workLog->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    
        return view('work_logs.show', compact('workLog', 'audits'));
    }
    

    

    // Procesa la actualización realizada por el administrador
    public function update(Request $request, $id)
    {
        // Validamos que 'check_in' y 'check_out' sean requeridos, sean fechas y además,
        // para 'check_in' se verifica que no sea posterior a 'check_out'.
        $validated = $request->validate([
            'check_in'  => 'required|date|before_or_equal:check_out',
            'check_out' => 'required|date',
        ], [
            'check_in.before_or_equal' => 'La fecha de entrada no puede ser posterior a la fecha de salida.',
        ]);

        // Buscamos el registro
        $workLog = WorkLog::findOrFail($id);

        // Normalizamos los valores existentes con Carbon (formato "Y-m-d\TH:i") para compararlos
        $existingCheckIn = $workLog->check_in ? \Carbon\Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i') : null;
        $existingCheckOut = $workLog->check_out ? \Carbon\Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i') : null;

        // Obtenemos los nuevos valores (ya validados)
        $inputCheckIn = $validated['check_in'];
        $inputCheckOut = $validated['check_out'];

        // Si los datos no han cambiado, se retorna un mensaje de error
        if ($existingCheckIn === $inputCheckIn && $existingCheckOut === $inputCheckOut) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', 'No se han realizado cambios en el registro.');
        }

        // Asignamos los nuevos valores y generamos el nuevo hash mediante el método del modelo
        $workLog->fill($validated);
        $workLog->hash = $workLog->generateHash();

        // Intentamos guardar, y en caso de error, capturamos la excepción y retornamos un mensaje
        try {
            $workLog->save();
        } catch (\Exception $e) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', 'Error al guardar los cambios: ' . $e->getMessage());
        }

        // Redirigimos a la vista de detalle del registro con un mensaje de éxito
        return redirect()->route('work_logs.show', $workLog->id)
            ->with('success', 'Registro actualizado y auditado correctamente.');
    }

    // Método para descargar reporte anual
    public function exportYearlyReport($year)
    {
        return Excel::download(new YearlyWorkLogsExport($year), 'work_logs_' . $year . '.xlsx');
    }
}
