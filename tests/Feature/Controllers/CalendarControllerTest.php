<?php

use App\Models\WorkLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra el calendario anual con los registros agrupados por fecha', function () {
    // Creamos un usuario y simulamos la autenticación
    $user = User::factory()->create();
    $this->actingAs($user);

    // Creamos algunos registro de WorkLog para el año 2025 con diferentes fechas
    WorkLog::factory()->create([
        'user_id'   => $user->id,
        'check_in'  => '2025-03-15 09:00:00',
        'check_out' => '2025-03-15 17:00:00',
    ]);

    WorkLog::factory()->create([
        'user_id'   => $user->id,
        'check_in'  => '2025-03-15 18:00:00',
        'check_out' => '2025-03-15 20:00:00',
    ]);

    WorkLog::factory()->create([
        'user_id'   => $user->id,
        'check_in'  => '2025-04-10 10:00:00',
        'check_out' => '2025-04-10 18:00:00',
    ]);

    // Realizamos la petición GET a la ruta '/calendar' pasando el parámetro "year"
    $response = $this->get('/calendar?year=2025');

    // Verificamos que la respuesta sea 200 y que se use la vista "calendar.index"
    $response->assertStatus(200);
    $response->assertViewIs('calendar.index');
    
    // Verificamos que la variable "year" se pase correctamente a la vista
    $response->assertViewHas('year', 2025);

    // Verificamos que la variable "logs" se agrupe correctamente.
    // Debido a que en el controlador se agrupa por fecha (formato 'Y-m-d')
    // se espera que existan claves para '2025-03-15' y '2025-04-10'
    $response->assertViewHas('logs', function ($logs) {
       // Al usar paginate() en otros controladores la verificación sería distinta,
       // pero aquí se usa "get()" (por lo que $logs es una colección).
       $keys = $logs->keys()->toArray();
       return in_array('2025-03-15', $keys) && in_array('2025-04-10', $keys);
    });
});
