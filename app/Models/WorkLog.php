<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkLog extends Model
{
    use HasFactory;

    // Se agregan los nuevos campos 'pause_start' y 'pause_end'
    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'hash',
        'pause_minutes',
        'pause_start',
        'pause_end',
        'ordinary_hours',
        'complementary_hours',
        'overtime_hours'
    ];

    // Propiedad temporal para el motivo de modificación (no se persistirá)
    public $temp_modification_reason;

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Genera el hash a partir de los campos relevantes, incluyendo los nuevos de pausa
    public function generateHash()
    {
        if ($this->check_in && $this->check_out) {
            $data = $this->user_id
                . '|' . $this->check_in
                . '|' . $this->check_out
                . '|' . ($this->pause_minutes ?? 0)
                . '|' . ($this->pause_start ? Carbon::parse($this->pause_start)->toDateTimeString() : '')
                . '|' . ($this->pause_end ? Carbon::parse($this->pause_end)->toDateTimeString() : '')
                . '|' . ($this->ordinary_hours ?? 0)
                . '|' . ($this->complementary_hours ?? 0)
                . '|' . ($this->overtime_hours ?? 0);

            return hash_hmac('sha256', $data, config('app.key'));
        }
        return null;
    }

    // Verifica el hash generando una nueva huella e igualándola al hash almacenado
    public function verifyHash()
    {
        if ($this->check_in && $this->check_out && !empty($this->hash)) {
            $data = $this->user_id
                . '|' . $this->check_in
                . '|' . $this->check_out
                . '|' . ($this->pause_minutes ?? 0)
                . '|' . ($this->pause_start ? Carbon::parse($this->pause_start)->toDateTimeString() : '')
                . '|' . ($this->pause_end ? Carbon::parse($this->pause_end)->toDateTimeString() : '')
                . '|' . ($this->ordinary_hours ?? 0)
                . '|' . ($this->complementary_hours ?? 0)
                . '|' . ($this->overtime_hours ?? 0);

            return hash_hmac('sha256', $data, config('app.key')) === $this->hash;
        }
        return false;
    }

    /**
     * Calcula el desglose de horas:
     * 1. Se obtienen las marcas de tiempo para check_in y check_out.
     * 2. Si se han definido pause_start y pause_end, se calcula la
     *    duración de la pausa; de lo contrario, se usa el campo pause_minutes.
     * 3. Se determina el total de minutos trabajados y se resta la pausa.
     * 4. Se recupera el horario asignado al usuario para el día y se
     *    clasifica el tiempo trabajado en ordinario, complementario o extraordinario.
     *
     * @return bool
     */
    public function calculateHours()
    {
        if (!$this->check_in || !$this->check_out) {
            \Log::debug('calculateHours: Falta check_in o check_out', [
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
            ]);
            return false;
        }

        // Convertir check_in y check_out a Carbon
        $checkIn  = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);
        
        \Log::debug('calculateHours: Valores de checkIn y checkOut', [
            'check_in'  => $checkIn->toDateTimeString(),
            'check_out' => $checkOut->toDateTimeString()
        ]);

        // Calcular minutos de pausa:
        if ($this->pause_start && $this->pause_end) {
            $pauseMinutes = Carbon::parse($this->pause_start)
                ->diffInMinutes(Carbon::parse($this->pause_end), true);
        } else {
            $pauseMinutes = $this->pause_minutes ?? 0;
        }
        
        \Log::debug('calculateHours: Minutos de pausa', ['pauseMinutes' => $pauseMinutes]);

        // Calcular los minutos trabajados netos restando la pausa
        $workedMinutes = $checkOut->diffInMinutes($checkIn, true) - $pauseMinutes;
        
        \Log::debug('calculateHours: Minutos trabajados netos', ['workedMinutes' => $workedMinutes]);

        // Determinar el día de la semana (en minúsculas)
        $dayOfWeek = strtolower($checkIn->format('l'));
        \Log::debug('calculateHours: Día de la semana', ['dayOfWeek' => $dayOfWeek]);

        // Valor por defecto de horas asignadas (7 horas)
        $defaultAssignedHours = 7;

        // Obtener el horario asignado al usuario para ese día
        $schedule = $this->user->workSchedule;
        if (!$schedule) {
            $assignedHours = $defaultAssignedHours;
            \Log::debug('calculateHours: No se encontró workSchedule. Usando valor por defecto', ['assignedHours' => $assignedHours]);
        } else {
            $field = $dayOfWeek . '_hours';
            $assignedHours = $schedule->$field ?? $defaultAssignedHours;
            \Log::debug('calculateHours: Horario asignado obtenido del workSchedule', [
                'field' => $field,
                'assignedHours' => $assignedHours
            ]);
        }

        // Convertir horas asignadas a minutos.
        $assignedMinutes = $assignedHours * 60;
        \Log::debug('calculateHours: Minutos asignados', ['assignedMinutes' => $assignedMinutes]);

        // Tipo de contrato (por defecto "fulltime")
        $contractType = $this->user->contract_type ?? 'fulltime';
        \Log::debug('calculateHours: Tipo de contrato', ['contractType' => $contractType]);

        // Calcular horas según lo trabajado
        if ($workedMinutes <= $assignedMinutes) {
            $this->ordinary_hours      = round($workedMinutes / 60, 2);
            $this->complementary_hours = 0;
            $this->overtime_hours      = 0;
            \Log::debug('calculateHours: Tiempo trabajado menor o igual a lo asignado', [
                'ordinary_hours' => $this->ordinary_hours
            ]);
        } else {
            $this->ordinary_hours = round($assignedMinutes / 60, 2);
            $extraMinutes = $workedMinutes - $assignedMinutes;
            \Log::debug('calculateHours: Tiempo extra calculado', ['extraMinutes' => $extraMinutes]);

            if ($contractType === 'fulltime') {
                $this->overtime_hours = round($extraMinutes / 60, 2);
                $this->complementary_hours = 0;
                \Log::debug('calculateHours: fulltime - Horas extra asignadas', [
                    'overtime_hours' => $this->overtime_hours
                ]);
            } else {
                $this->complementary_hours = round($extraMinutes / 60, 2);
                $this->overtime_hours = 0;
                \Log::debug('calculateHours: parttime - Horas complementarias asignadas', [
                    'complementary_hours' => $this->complementary_hours
                ]);
            }
        }

        // Registrar log final antes de guardar
        \Log::debug('calculateHours: Valores finales asignados', [
            'ordinary_hours'      => $this->ordinary_hours,
            'complementary_hours' => $this->complementary_hours,
            'overtime_hours'      => $this->overtime_hours,
            'hash'                => $this->generateHash()
        ]);

        return $this->save();
    }


    /**
     * Compara los valores actuales del modelo con los datos recibidos.
     *
     * @param array $newData Los datos del request.
     * @return bool Devuelve true si se detecta al menos un cambio.
     */
    public function hasDataChanges(array $newData): bool
    {
        // Campos que queremos comparar.
        $fieldsToCompare = [
            'check_in',
            'check_out',
            'pause_start',
            'pause_end',
            'ordinary_hours',
            'complementary_hours',
            'overtime_hours',
            'pause_minutes'
        ];

        foreach ($fieldsToCompare as $field) {
            $currentValue = $this->$field;
            $newValue = $newData[$field] ?? null;

            // Si es uno de los campos de fecha, los convertimos a un formato consistente
            if (in_array($field, ['check_in', 'check_out', 'pause_start', 'pause_end'])) {
                $currentFormatted = $currentValue ? \Carbon\Carbon::parse($currentValue)->format('Y-m-d\TH:i') : '';
                $newFormatted = $newValue ? \Carbon\Carbon::parse($newValue)->format('Y-m-d\TH:i') : '';
                if ($currentFormatted !== $newFormatted) {
                    return true;
                }
            } else {
                // Para campos numéricos o de otro tipo, comparamos como strings
                if ((string)$currentValue !== (string)$newValue) {
                    return true;
                }
            }
        }

        return false;
    }


    // Hook para actualizar el hash al guardar el registro
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($log) {
            if ($log->check_in && $log->check_out) {
                $log->hash = $log->generateHash();
            }
        });
    }
}
