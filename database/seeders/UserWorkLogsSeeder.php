<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkLog;

class UserWorkLogsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $totalUsers = $users->count();

        $this->command->info("Asignando 300 WorkLogs a cada uno de los {$totalUsers} usuarios existentes...");

        foreach ($users as $user) {
            WorkLog::factory()->count(300)->create([
                'user_id' => $user->id,
            ]);

            $this->command->info("Se asignaron 300 WorkLogs al usuario con ID: {$user->id}.");
        }

        $this->command->info("Se han asignado WorkLogs a todos los usuarios existentes.");
    }
}
