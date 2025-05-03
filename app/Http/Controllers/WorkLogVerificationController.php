<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkLog;

class WorkLogVerificationController extends Controller
{
    /**
     * Muestra el formulario para ingresar el código hash.
     *
     * Si se conoce el ID del work log (por ejemplo, vía query parameter), se carga el registro;
     * en caso contrario, se pedirá que se ingrese manualmente.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showForm(Request $request)
    {
        $workLog = null;
        if ($request->has('work_log_id')) {
            $workLog = WorkLog::find($request->input('work_log_id'));
        }
        return view('work_logs.verify', compact('workLog'));
    }

    /**
     * Procesa el formulario de verificación.
     * 
     * Valida que se reciba el work_log_id y el código hash ingresado, y compara el código ingresado
     * con el hash almacenado del work log.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function verify(Request $request)
    {
        // Valida que se reciba el ID y el hash ingresado.
        $data = $request->validate([
            'work_log_id' => 'required|integer|exists:work_logs,id',
            'hash_code'   => 'required|string',
        ], [
            'work_log_id.required' => 'No se encontró el identificador del registro.',
            'hash_code.required'   => 'Debes ingresar el código hash.',
        ]);

        // Recupera el registro
        $workLog = WorkLog::findOrFail($data['work_log_id']);

        // Compara el código ingresado con el hash almacenado
        $isValid = ($data['hash_code'] === $workLog->hash);

        // Retorna la misma vista con la variable $isValid para mostrar el resultado
        return view('work_logs.verify', compact('workLog', 'isValid'));
    }
}
