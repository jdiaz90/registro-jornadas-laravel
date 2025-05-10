<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkSchedule;

class WorkSchedulesSeeder extends Seeder
{
    public function run()
    {
        // Para cada usuario, creamos un WorkSchedule asociado.
        User::all()->each(function ($user) {
            WorkSchedule::factory()->create(['user_id' => $user->id]);
        });
    }
}
