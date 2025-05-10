<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkLog;

class WorkLogsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $totalUsers = $users->count();

        $bar = $this->command->getOutput()->createProgressBar($totalUsers);
        $bar->start();

        foreach ($users as $user) {
            // Creación de 300 work logs para cada usuario
            WorkLog::factory(300)->create(['user_id' => $user->id]);
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nWork Logs have been seeded for {$totalUsers} users.");
    }
}
