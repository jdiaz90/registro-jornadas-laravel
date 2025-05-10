<?php

namespace Database\Factories;

use App\Models\WorkLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WorkLogFactory extends Factory
{
    protected $model = WorkLog::class;

    public function definition()
    {
        // Obtener el año actual
        $currentYear = Carbon::now()->year;
        // Seleccionar un año aleatorio entre 2021 y el año actual
        $year = $this->faker->numberBetween(2021, $currentYear);

        // Si el año es el actual, el mes máximo es el mes actual; de lo contrario, 12
        $maxMonth = ($year === $currentYear) ? Carbon::now()->month : 12;
        $month = $this->faker->numberBetween(1, $maxMonth);

        // Si el año y mes son los actuales, el día máximo es el día de hoy; de lo contrario, se usa el número total de días del mes
        if ($year === $currentYear && $month === Carbon::now()->month) {
            $maxDay = Carbon::now()->day;
        } else {
            $maxDay = Carbon::create($year, $month, 1)->daysInMonth;
        }
        $day = $this->faker->numberBetween(1, $maxDay);

        // Crear una fecha base para el día seleccionado
        $date = Carbon::create($year, $month, $day);

        // Generar check_in: hora aleatoria entre las 8:00 y las 10:00
        $checkInHour = $this->faker->numberBetween(8, 10);
        $checkInMinute = $this->faker->numberBetween(0, 59);
        $checkIn = (clone $date)->setTime($checkInHour, $checkInMinute);

        // Generar check_out: hora aleatoria entre las 17:00 y las 19:00 del mismo día
        $checkOutHour = $this->faker->numberBetween(17, 19);
        $checkOutMinute = $this->faker->numberBetween(0, 59);
        $checkOut = (clone $date)->setTime($checkOutHour, $checkOutMinute);

        // Simular una pausa en el 70% de los casos
        $hasPause = $this->faker->boolean(70);
        if ($hasPause) {
            // La pausa inicia entre 90 y 180 minutos después del check_in
            $pauseStart = (clone $checkIn)->addMinutes($this->faker->numberBetween(90, 180));
            // La pausa dura entre 15 y 60 minutos
            $pauseEnd = (clone $pauseStart)->addMinutes($this->faker->numberBetween(15, 60));
            $pauseMinutes = $pauseStart->diffInMinutes($pauseEnd);
        } else {
            $pauseStart = null;
            $pauseEnd = null;
            $pauseMinutes = 0;
        }

        // Valores arbitrarios para el desglose de horas (estos podrían recalcularse con calculateHours())
        $ordinaryHours      = $this->faker->randomFloat(2, 6, 7);
        $complementaryHours = $this->faker->randomFloat(2, 0, 2);
        $overtimeHours      = $this->faker->randomFloat(2, 0, 2);

        return [
            // Si no se especifica user_id, se crea un usuario de prueba automáticamente.
            'user_id'             => User::factory(),
            'check_in'            => $checkIn->toDateTimeString(),
            'check_out'           => $checkOut->toDateTimeString(),
            'pause_start'         => $pauseStart ? $pauseStart->toDateTimeString() : null,
            'pause_end'           => $pauseEnd ? $pauseEnd->toDateTimeString() : null,
            'pause_minutes'       => $pauseMinutes,
            'ordinary_hours'      => $ordinaryHours,
            'complementary_hours' => $complementaryHours,
            'overtime_hours'      => $overtimeHours,
            'hash'                => $this->faker->sha256,
        ];
    }
}
