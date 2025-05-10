<?php

namespace Database\Factories;

use App\Models\WorkSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkScheduleFactory extends Factory
{
    protected $model = WorkSchedule::class;

    public function definition()
    {
        return [
            // Se asigna un usuario; en el seeder podrás forzar el user_id a uno existente.
            'user_id'                => User::factory(),
            'monday_hours'           => 7,
            'monday_break_minutes'   => 0,
            'tuesday_hours'          => 7,
            'tuesday_break_minutes'  => 0,
            'wednesday_hours'        => 7,
            'wednesday_break_minutes'=> 0,
            'thursday_hours'         => 7,
            'thursday_break_minutes' => 0,
            'friday_hours'           => 7,
            'friday_break_minutes'   => 0,
            'saturday_hours'         => 0,
            'saturday_break_minutes' => 0,
            'sunday_hours'           => 0,
            'sunday_break_minutes'   => 0,
        ];
    }
}
