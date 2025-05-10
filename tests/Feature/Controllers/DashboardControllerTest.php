<?php

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra el dashboard con el recuento de work logs para el usuario autenticado', function () {
    // Creamos un usuario
    $user = User::factory()->create();

    // Creamos 5 registros de WorkLog para este usuario
    WorkLog::factory()->count(5)->create([
        'user_id' => $user->id,
    ]);

    // Autenticamos al usuario
    $this->actingAs($user);

    // Se asume que la ruta para el dashboard es '/dashboard'
    $response = $this->get('/dashboard');

    // Verificamos que el status HTTP sea 200
    $response->assertStatus(200);

    // Verificamos que la vista sea 'dashboard'
    $response->assertViewIs('dashboard');

    // Verificamos que la variable 'logCount' se pase a la vista y tenga el valor esperado (5)
    $response->assertViewHas('logCount', 5);
});

it('muestra el dashboard con logCount igual a 0 si el usuario no tiene work logs', function () {
    // Creamos un usuario sin work logs
    $user = User::factory()->create();

    // Autenticamos al usuario
    $this->actingAs($user);

    // Se asume que la ruta para el dashboard es '/dashboard'
    $response = $this->get('/dashboard');

    // Verificamos que el status HTTP sea 200
    $response->assertStatus(200);

    // Verificamos que la vista usada sea 'dashboard'
    $response->assertViewIs('dashboard');

    // Verificamos que la variable 'logCount' sea 0
    $response->assertViewHas('logCount', 0);
});
