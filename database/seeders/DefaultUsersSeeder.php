<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Usamos una barra de progreso para los 2 usuarios
        $usersCount = 2;
        $bar = $this->command->getOutput()->createProgressBar($usersCount);
        $bar->start();

        // Usuario Administrador
        $admin = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('password'), // Cambia la contraseña en producción
            'remember_token'    => Str::random(10),
            'role'              => 'admin',
            'locale'            => 'es',
            'contract_type'     => 'fulltime',
        ]);
        WorkSchedule::create([
            'user_id'                => $admin->id,
            'monday_hours'           => 7,
            'tuesday_hours'          => 7,
            'wednesday_hours'        => 7,
            'thursday_hours'         => 7,
            'friday_hours'           => 7,
            'saturday_hours'         => 7,
            'sunday_hours'           => 7,
        ]);
        $bar->advance();

        // Usuario Normal
        $user = User::create([
            'name'              => 'Usuario',
            'email'             => 'usuario@example.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(10),
            'role'              => 'user',
            'locale'            => 'es',
            'contract_type'     => 'fulltime',
        ]);
        WorkSchedule::create([
            'user_id'                => $user->id,
            'monday_hours'           => 7,
            'tuesday_hours'          => 7,
            'wednesday_hours'        => 7,
            'thursday_hours'         => 7,
            'friday_hours'           => 7,
            'saturday_hours'         => 7,
            'sunday_hours'           => 7,
        ]);
        $bar->advance();

        $bar->finish();
        $this->command->info("\nDefault users and their work schedules have been seeded.");
    }
}
