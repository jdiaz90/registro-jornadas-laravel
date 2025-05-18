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
        // Validar que existan tanto check_in como check_out
        if (!$this->check_in || !$this->check_out) {
            return false;
        }

        // Convertir check_in y check_out a instancias de Carbon
        $checkIn  = \Carbon\Carbon::parse($this->check_in);
        $checkOut = \Carbon\Carbon::parse($this->check_out);

        // Calcular los minutos de pausa usando abs() para asegurarse de que son positivos
        if ($this->pause_start && $this->pause_end) {
            $pauseStart = \Carbon\Carbon::parse($this->pause_start);
            $pauseEnd   = \Carbon\Carbon::parse($this->pause_end);
            $pauseMinutes = abs($pauseStart->diffInMinutes($pauseEnd));
            $this->pause_minutes = (int) $pauseMinutes;
        } else {
            $pauseMinutes = isset($this->pause_minutes) ? $this->pause_minutes : 0;
        }

        // Calcular los minutos trabajados netos: diferencia entre check_in y check_out menos la pausa
        // Se utiliza el parámetro true para obtener la diferencia con signo, pero lo forzamos a ser no negativo
        $workedMinutes = $checkOut->diffInMinutes($checkIn, true) - $pauseMinutes;
        
        // Si la resta resulta negativa, forzamos el valor a 0
        if ($workedMinutes < 0) {
            $workedMinutes = 0;
        }

        // Forzar que se use el nombre del día en inglés para buscar en el WorkSchedule
        $dayOfWeek = strtolower($checkIn->locale('en')->isoFormat('dddd'));

        // Valor por defecto asignado en horas
        $defaultAssignedHours = 7;
        $schedule = $this->user->workSchedule;
        if (!$schedule) {
            $assignedHours = $defaultAssignedHours;
        } else {
            $field = $dayOfWeek . '_hours';
            $assignedHours = $schedule->$field ?? $defaultAssignedHours;
            // Si es domingo y el schedule tiene 0, se usa el valor por defecto
            if ($dayOfWeek === 'sunday' && $assignedHours == 0) {
                $assignedHours = $defaultAssignedHours;
            }
        }
        
        // Convertir las horas asignadas a minutos
        $assignedMinutes = $assignedHours * 60;

        // Obtener el tipo de contrato del usuario (por defecto "fulltime")
        $contractType = $this->user->contract_type ?? 'fulltime';

        // Calcular la distribución de horas según si se excede o no lo asignado
        if ($workedMinutes <= $assignedMinutes) {
            $this->ordinary_hours = round($workedMinutes / 60, 2);
            $this->complementary_hours = 0;
            $this->overtime_hours = 0;
        } else {
            // Se asignan las horas ordinarias hasta el límite
            $this->ordinary_hours = round($assignedMinutes / 60, 2);
            $extraMinutes = $workedMinutes - $assignedMinutes;
            if ($contractType === 'fulltime') {
                $this->overtime_hours = round($extraMinutes / 60, 2);
                $this->complementary_hours = 0;
            } else {
                $this->complementary_hours = round($extraMinutes / 60, 2);
                $this->overtime_hours = 0;
            }
        }

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
