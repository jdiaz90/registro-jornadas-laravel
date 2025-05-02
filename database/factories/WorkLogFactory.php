<?php

namespace Database\Factories;

use App\Models\WorkLog;
use App\Models\User;   // Importa el modelo User
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WorkLogFactory extends Factory
{
    protected $model = WorkLog::class;

    public function definition()
    {
        // Fijamos el año de prueba en 2025
        $year = 2025;
        // Seleccionamos un mes aleatorio (1 a 12)
        $month = $this->faker->numberBetween(1, 12);
        // Obtenemos el n\u00FAmero de d\u00EDas del mes
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        // Seleccionamos un d\u00EDa aleatorio del mes
        $day = $this->faker->numberBetween(1, $daysInMonth);

        // Creamos una fecha base del d\u00EDa seleccionado
        $date = Carbon::create($year, $month, $day);

        // Generamos un check_in: hora aleatoria entre las 8:00 y 10:00
        $checkInHour = $this->faker->numberBetween(8, 10);
        $checkInMinute = $this->faker->numberBetween(0, 59);
        $checkIn = (clone $date)->setTime($checkInHour, $checkInMinute);

        // Generamos un check_out: hora aleatoria entre las 17:00 y 19:00
        $checkOutHour = $this->faker->numberBetween(17, 19);
        $checkOutMinute = $this->faker->numberBetween(0, 59);
        $checkOut = (clone $date)->setTime($checkOutHour, $checkOutMinute);

        return [
            // Si no especificamos user_id al crear, se creará un usuario de prueba
            'user_id'   => User::factory(),
            'check_in'  => $checkIn,
            'check_out' => $checkOut,
            'hash'      => $this->faker->sha256,
        ];
    }
}
