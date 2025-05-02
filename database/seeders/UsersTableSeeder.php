<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Usuario Administrador
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),  // Recuerda cambiar la contraseña en un entorno real
            'role'     => 'admin',  // Asumiendo que en tu tabla de usuarios existe un campo 'role'
        ]);

        // Usuario Normal
        User::create([
            'name'     => 'Usuario',
            'email'    => 'usuario@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // Puedes agregar más usuarios de prueba según necesites
    }
}
