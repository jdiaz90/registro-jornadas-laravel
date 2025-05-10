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
            return false;
        }

        // Convertir check_in y check_out a Carbon
        $checkIn  = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);

        // Calcular minutos de pausa:
        // Si se han definido pause_start y pause_end, se calcula su diferencia.
        // De lo contrario, se usa el valor en pause_minutes.
        if ($this->pause_start && $this->pause_end) {
            $pauseMinutes = Carbon::parse($this->pause_start)->diffInMinutes(Carbon::parse($this->pause_end));
        } else {
            $pauseMinutes = $this->pause_minutes ?? 0;
        }

        $workedMinutes = $checkOut->diffInMinutes($checkIn) - $pauseMinutes;

        // Determinar el día de la semana (en minúsculas) a partir del check_in.
        $dayOfWeek = strtolower($checkIn->format('l'));

        // Definir el valor por defecto de horas asignadas para el día según el convenio (7 horas).
        $defaultAssignedHours = 7;

        // Obtener el horario asignado al usuario para ese día.
        // Se asume que el usuario tiene una relación 'workSchedule'
        $schedule = $this->user->workSchedule;
        if (!$schedule) {
            $assignedHours = $defaultAssignedHours;
        } else {
            // Armar dinámicamente el nombre del campo, por ejemplo "monday_hours".
            $field = $dayOfWeek . '_hours';
            $assignedHours = $schedule->$field ?? $defaultAssignedHours;
        }

        // Convertir las horas asignadas a minutos.
        $assignedMinutes = $assignedHours * 60;

        // Recuperar el tipo de contrato del usuario, por defecto 'fulltime'
        $contractType = $this->user->contract_type ?? 'fulltime';

        if ($workedMinutes <= $assignedMinutes) {
            // Si el tiempo trabajado es menor o igual a lo asignado, todo es ordinario.
            $this->ordinary_hours      = round($workedMinutes / 60, 2);
            $this->complementary_hours = 0;
            $this->overtime_hours      = 0;
        } else {
            // Se asigna el total de horas asignadas como ordinarias.
            $this->ordinary_hours = round($assignedMinutes / 60, 2);
            $extraMinutes = $workedMinutes - $assignedMinutes;

            // Clasificar el exceso según el tipo de contrato.
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
