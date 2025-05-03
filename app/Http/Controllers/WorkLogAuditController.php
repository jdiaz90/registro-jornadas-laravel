<?php

namespace App\Http\Controllers;

use App\Models\WorkLogAudit;
use Illuminate\Http\Request;

class WorkLogAuditController extends Controller
{
    /**
     * Muestra una lista paginada de los registros de auditoría.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Se cargan los registros de auditoría, incluyendo la relación con WorkLog si es necesaria.
        $audits = WorkLogAudit::with('workLog')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('work_log_audits.index', compact('audits'));
    }

    /**
     * Muestra el detalle de un registro de auditoría.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $audit = WorkLogAudit::with('workLog')->findOrFail($id);
        return view('work_log_audits.show', compact('audit'));
    }
}
