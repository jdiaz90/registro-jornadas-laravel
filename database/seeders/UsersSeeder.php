<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Creamos 50 usuarios adicionales vía factory.
        $users = User::factory(50)->create();
        $totalUsers = $users->count();

        $bar = $this->command->getOutput()->createProgressBar($totalUsers);
        $bar->start();
        foreach ($users as $user) {
            // Aquí se podría, por ejemplo, crear un WorkSchedule para cada usuario adicional si así lo deseas.
            // O bien dejarlo para otro seeder.
            $bar->advance();
        }
        $bar->finish();
        $this->command->info("\n{$totalUsers} additional users have been seeded.");
    }
}
