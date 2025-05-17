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
        // Si el registro no estaba completo (es decir, si check_out era null)
        // entonces se trata de la transición al registro completo y no se genera auditoría.
        if (is_null($workLog->getOriginal('check_out'))) {
            return;
        }

        // Se asegura que el registro esté completo antes de continuar con el audit
        if (!$workLog->check_in || !$workLog->check_out) {
            return;
        }

        // Obtenemos el array de campos modificados
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
            // Se registra la auditoría solo cuando se trata de modificaciones en un registro ya completo
            WorkLogAudit::create([
                'work_log_id'             => $workLog->id,
                'old_check_in'            => $workLog->getOriginal('check_in'),
                'new_check_in'            => $workLog->check_in,
                'old_check_out'           => $workLog->getOriginal('check_out'),
                'new_check_out'           => $workLog->check_out,
                'old_hash'                => $workLog->getOriginal('hash'),
                'new_hash'                => $workLog->hash,
                'updated_by'              => auth()->check() ? auth()->user()->name : 'sistema',
                'old_ordinary_hours'      => $workLog->getOriginal('ordinary_hours') ?? 0,
                'new_ordinary_hours'      => $workLog->ordinary_hours ?? 0,
                'old_complementary_hours' => $workLog->getOriginal('complementary_hours') ?? 0,
                'new_complementary_hours' => $workLog->complementary_hours ?? 0,
                'old_overtime_hours'      => $workLog->getOriginal('overtime_hours') ?? 0,
                'new_overtime_hours'      => $workLog->overtime_hours ?? 0,
                'old_pause_start'         => $workLog->getOriginal('pause_start'),
                'new_pause_start'         => $workLog->pause_start,
                'old_pause_end'           => $workLog->getOriginal('pause_end'),
                'new_pause_end'           => $workLog->pause_end,
                'old_pause_minutes'       => $workLog->getOriginal('pause_minutes') ?? 0,
                'new_pause_minutes'       => $workLog->pause_minutes ?? 0,
                'modification_reason'     => $workLog->temp_modification_reason, // Lectura de la propiedad temporal
            ]);
        }
    }


}
