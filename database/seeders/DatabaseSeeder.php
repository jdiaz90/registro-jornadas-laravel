<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            // Puedes llamar a otros seeders aquí, como uno para WorkLogs, etc.
        ]);
    }
}
