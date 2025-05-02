<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkLog;

class UserWithWorkLogsSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creando 50 usuarios con 300 registros cada uno...');

        User::factory()
            ->count(50)
            ->has(WorkLog::factory()->count(300), 'workLogs')
            ->create();

        $this->command->info('Se han creado 50 usuarios con 300 WorkLogs cada uno.');
    }
}
