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
        // Determinar si se han modificado alguno de los campos que deseamos auditar.
        // Esto evita insertar un registro de auditoría si, por ejemplo, se actualizan otros campos.
        $dirty = $workLog->getDirty();

        if (
            array_key_exists('check_in', $dirty) || 
            array_key_exists('check_out', $dirty) || 
            array_key_exists('hash', $dirty)
        ) {
            // Registramos la auditoría
            \App\Models\WorkLogAudit::create([
                'work_log_id'  => $workLog->id,
                'old_check_in' => $workLog->getOriginal('check_in'),
                'new_check_in' => $workLog->check_in,
                'old_check_out'=> $workLog->getOriginal('check_out'),
                'new_check_out'=> $workLog->check_out,
                'old_hash'     => $workLog->getOriginal('hash'),
                'new_hash'     => $workLog->hash, // se asume que el nuevo hash se calcula antes de guardar
                'updated_by'   => auth()->check() ? auth()->user()->name : 'sistema',
            ]);
        }
    }
}
