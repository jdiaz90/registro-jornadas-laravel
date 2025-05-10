<?php

namespace App\Observers;

use App\Models\WorkLog;
use App\Models\WorkLogAudit;

class WorkLogObserver
{
    /**
     * Se ejecuta antes de actualizar un registro en work_logs.
     *
     * @param  \App\Models\WorkLog  $workLog
     * @return void
     */
    public function updating(WorkLog $workLog)
    {
        // Obtenemos el array de campos modificados.
        $dirty = $workLog->getDirty();

        // Verificamos si se han modificado alguno de los campos que queremos auditar.
        if (
            array_key_exists('check_in', $dirty) || 
            array_key_exists('check_out', $dirty) || 
            array_key_exists('hash', $dirty) ||
            array_key_exists('pause_start', $dirty) ||
            array_key_exists('pause_end', $dirty) ||
            array_key_exists('ordinary_hours', $dirty) ||
            array_key_exists('complementary_hours', $dirty) ||
            array_key_exists('overtime_hours', $dirty) ||
            array_key_exists('pause_minutes', $dirty)
        ) {
            WorkLogAudit::create([
                'work_log_id'             => $workLog->id,
                'old_check_in'            => $workLog->getOriginal('check_in'),
                'new_check_in'            => $workLog->check_in,
                'old_check_out'           => $workLog->getOriginal('check_out'),
                'new_check_out'           => $workLog->check_out,
                'old_pause_start'         => $workLog->getOriginal('pause_start'),
                'new_pause_start'         => $workLog->pause_start,
                'old_pause_end'           => $workLog->getOriginal('pause_end'),
                'new_pause_end'           => $workLog->pause_end,
                'old_ordinary_hours'      => $workLog->getOriginal('ordinary_hours') ?? 0,
                'new_ordinary_hours'      => $workLog->ordinary_hours ?? 0,
                'old_complementary_hours' => $workLog->getOriginal('complementary_hours') ?? 0,
                'new_complementary_hours' => $workLog->complementary_hours ?? 0,
                'old_overtime_hours'      => $workLog->getOriginal('overtime_hours') ?? 0,
                'new_overtime_hours'      => $workLog->overtime_hours ?? 0,
                'old_pause_minutes'       => $workLog->getOriginal('pause_minutes') ?? 0,
                'new_pause_minutes'       => $workLog->pause_minutes ?? 0,
                'old_hash'                => $workLog->getOriginal('hash'),
                'new_hash'                => $workLog->hash, // Se asume que el nuevo hash ya fue calculado
                'updated_by'              => auth()->check() ? auth()->user()->name : 'sistema',
                'modification_reason'     => null, // Puedes asignar una razón por defecto si lo crees conveniente
            ]);
        }
    }
}
