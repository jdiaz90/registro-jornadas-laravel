<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("Starting Database Seeding...");

        $this->call([
            DefaultUsersSeeder::class,
            UsersSeeder::class,
            WorkLogsSeeder::class,
            WorkLogAuditsSeeder::class,
        ]);

        $this->command->info("Database Seeding Completed!");
    }
}
