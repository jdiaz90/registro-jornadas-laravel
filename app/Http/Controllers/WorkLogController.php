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
        // Verificamos que el usuario no tenga un registro en curso.
        $openLog = WorkLog::where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();

        if ($openLog) {
            return back()->with('error', __('work_logs.messages.check_in.already_open'));
        }

        WorkLog::create([
            'user_id'  => Auth::id(),
            'check_in' => Carbon::now(),
        ]);

        return back()->with('success', __('work_logs.messages.check_in.success'));
    }

    // Registrar la salida
    public function checkOut(Request $request)
    {
        // Encontrar el registro en curso.
        $log = WorkLog::where('user_id', Auth::id())
            ->whereNull('check_out')
            ->first();

        if (!$log) {
            return back()->with('error', __('work_logs.messages.check_out.no_open'));
        }

        $log->update([
            'check_out' => Carbon::now(),
        ]);

        return back()->with('success', __('work_logs.messages.check_out.success'));
    }

    // Muestra el formulario para que el administrador edite el registro.
    public function edit($id)
    {
        $workLog = WorkLog::findOrFail($id);
        return view('work_logs.edit', compact('workLog'));
    }

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
    public function update(Request $request, $id)
    {
        // Validar los campos, incluyendo modification_reason
        $validated = $request->validate([
            'check_in'            => 'required|date|before_or_equal:check_out',
            'check_out'           => 'required|date',
            'pause_start'         => 'nullable|date',
            'pause_end'           => 'nullable|date|after:pause_start',
            'ordinary_hours'      => 'nullable|numeric',
            'complementary_hours' => 'nullable|numeric',
            'overtime_hours'      => 'nullable|numeric',
            'pause_minutes'       => 'nullable|integer',
            'modification_reason' => 'required|string|max:255',
        ], [
            'check_in.before_or_equal' => 'La fecha de entrada no puede ser posterior a la fecha de salida.',
            'pause_end.after'          => 'La hora de finalización de la pausa debe ser posterior a la de inicio.',
        ]);

        // Buscamos el registro
        $workLog = WorkLog::findOrFail($id);

        // (Opcional) Normalizamos los valores actuales para comparación.
        $existingCheckIn    = $workLog->check_in ? \Carbon\Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i') : null;
        $existingCheckOut   = $workLog->check_out ? \Carbon\Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i') : null;
        $existingPauseStart = $workLog->pause_start ? \Carbon\Carbon::parse($workLog->pause_start)->format('Y-m-d\TH:i') : null;
        $existingPauseEnd   = $workLog->pause_end ? \Carbon\Carbon::parse($workLog->pause_end)->format('Y-m-d\TH:i') : null;

        // Valores existentes para los campos numéricos:
        $existingOrdinaryHours      = $workLog->ordinary_hours;
        $existingComplementaryHours = $workLog->complementary_hours;
        $existingOvertimeHours      = $workLog->overtime_hours;
        $existingPauseMinutes       = $workLog->pause_minutes;

        // Extraemos los nuevos valores para las fechas.
        $inputCheckIn    = $validated['check_in'];
        $inputCheckOut   = $validated['check_out'];
        $inputPauseStart = $validated['pause_start'] ?? null;
        $inputPauseEnd   = $validated['pause_end'] ?? null;

        // Extraemos los valores numéricos.
        $inputOrdinaryHours      = $validated['ordinary_hours'] ?? null;
        $inputComplementaryHours = $validated['complementary_hours'] ?? null;
        $inputOvertimeHours      = $validated['overtime_hours'] ?? null;
        $inputPauseMinutes       = $validated['pause_minutes'] ?? null;

        // Comprobamos que al menos haya algún cambio.
        if (
            $existingCheckIn === $inputCheckIn &&
            $existingCheckOut === $inputCheckOut &&
            $existingPauseStart === $inputPauseStart &&
            $existingPauseEnd === $inputPauseEnd &&
            $existingOrdinaryHours == $inputOrdinaryHours &&
            $existingComplementaryHours == $inputComplementaryHours &&
            $existingOvertimeHours == $inputOvertimeHours &&
            $existingPauseMinutes == $inputPauseMinutes
        ) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', __('work_logs.messages.update.no_changes'));
        }

        // Extraemos el motivo de modificación y lo eliminamos del array que se actualizará
        $modificationReason = $validated['modification_reason'];
        $data = $validated;
        unset($data['modification_reason']);

        // Asignamos el resto de los valores al modelo
        $workLog->fill($data);
        
        // Asignamos el motivo a la propiedad temporal en lugar de al array de atributos
        $workLog->temp_modification_reason = $modificationReason;

        // Recalcula el hash (ejemplo)
        $workLog->hash = $workLog->generateHash();

        // Intentamos guardar los cambios
        try {
            $workLog->save();
        } catch (\Exception $e) {
            return redirect()->route('admin.work_logs.edit', $id)
                ->with('error', __('work_logs.messages.update.save_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('work_logs.show', $workLog->id)
            ->with('success', __('work_logs.messages.update.success'));
    }

    // Método para descargar reporte anual.
    public function exportYearlyReport($year)
    {
        return Excel::download(new YearlyWorkLogsExport($year), 'work_logs_' . $year . '.xlsx');
    }
}
