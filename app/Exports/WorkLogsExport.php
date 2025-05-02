<?php

namespace App\Exports;

use App\Models\WorkLog;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkLogsExport implements FromCollection, WithHeadings
{
    /**
     * Retorna la colección de WorkLogs a exportar.
     */
    public function collection()
    {
        return WorkLog::select('id', 'check_in', 'check_out', 'hash')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Define los encabezados que tendrá la hoja de Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Entrada',
            'Salida',
            'Hash'
        ];
    }
}
