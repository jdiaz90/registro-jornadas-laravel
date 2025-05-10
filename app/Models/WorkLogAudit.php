<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkLogAudit extends Model
{

    use HasFactory;

    protected $table = 'work_logs_audits';

    protected $fillable = [
        'work_log_id',

        // Campos de check-in y check-out
        'old_check_in',
        'new_check_in',
        'old_check_out',
        'new_check_out',

        // Campos de pausa (inicio y fin)
        'old_pause_minutes',
        'new_pause_minutes',
        'old_pause_minutes',
        'new_pause_minutes',

        // Campos del desglose de horas
        'old_ordinary_hours',
        'new_ordinary_hours',
        'old_complementary_hours',
        'new_complementary_hours',
        'old_overtime_hours',
        'new_overtime_hours',

        // Minutos de pausa
        'old_pause_minutes',
        'new_pause_minutes',

        // Hash
        'old_hash',
        'new_hash',

        // Usuario que actualizó
        'updated_by',
    ];

    protected $casts = [
        // Convertir los valores numéricos a float o integer según corresponda.
        'old_ordinary_hours'      => 'float',
        'new_ordinary_hours'      => 'float',
        'old_complementary_hours' => 'float',
        'new_complementary_hours' => 'float',
        'old_overtime_hours'      => 'float',
        'new_overtime_hours'      => 'float',
        'old_pause_minutes'       => 'integer',
        'new_pause_minutes'       => 'integer',
    ];
}
