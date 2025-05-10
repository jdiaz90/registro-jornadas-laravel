<?php

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra el formulario sin work_log cargado si no se envía work_log_id', function () {
    // Simulamos un usuario autenticado
    $user = User::factory()->create();
    $this->actingAs($user);

    // Se accede a la ruta sin parámetro work_log_id
    $response = $this->get('/verify-worklog');

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.verify');
    // Se espera que "workLog" sea null
    $response->assertViewHas('workLog', null);
});

it('muestra el formulario con el work_log cuando se envía work_log_id', function () {
    // Simulamos un usuario autenticado
    $user = User::factory()->create();
    $this->actingAs($user);

    // Creamos un registro de WorkLog
    $workLog = WorkLog::factory()->create();

    // Se accede a la ruta enviando work_log_id en el query string
    $response = $this->get('/verify-worklog?work_log_id=' . $workLog->id);

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.verify');
    // Verificamos que la variable "workLog" en la vista corresponde al registro creado
    $response->assertViewHas('workLog', function ($viewWorkLog) use ($workLog) {
        return $viewWorkLog->id === $workLog->id;
    });
});

it('verifica correctamente el hash cuando el código es válido', function () {
    // Simulamos un usuario autenticado
    $user = User::factory()->create();
    $this->actingAs($user);

    $hash = 'correcthash123';
    // Creamos un registro de WorkLog con un hash definido
    $workLog = WorkLog::factory()->create(['hash' => $hash]);

    // Enviamos la petición POST con datos válidos
    $data = [
        'work_log_id' => $workLog->id,
        'hash_code'   => $hash,
    ];

    $response = $this->post('/verify-worklog', $data);

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.verify');
    // Se espera que la variable isValid tenga valor true
    $response->assertViewHas('isValid', true);
});

it('indica verificación inválida cuando el hash no coincide', function () {
    // Simulamos un usuario autenticado
    $user = User::factory()->create();
    $this->actingAs($user);

    $hash = 'correcthash123';
    // Creamos un registro de WorkLog con un hash definido
    $workLog = WorkLog::factory()->create(['hash' => $hash]);

    // Enviamos la petición POST con un hash incorrecto
    $data = [
        'work_log_id' => $workLog->id,
        'hash_code'   => 'wronghash',
    ];

    $response = $this->post('/verify-worklog', $data);

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.verify');
    // Se espera que la variable isValid tenga valor false
    $response->assertViewHas('isValid', false);
});
