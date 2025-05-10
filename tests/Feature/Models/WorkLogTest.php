<?php

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('genera y verifica el hash correctamente', function () {
    // Creamos un usuario
    $user = User::factory()->create();

    // Creamos un WorkLog. Gracias al hook "saving", se generará el hash.
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-10 09:00:00',
        'check_out'     => '2025-05-10 17:00:00',
        'pause_minutes' => 0,
    ]);

    expect($workLog->hash)->not->toBeNull();
    expect($workLog->verifyHash())->toBeTrue();
});

it('calcula correctamente las horas cuando lo trabajado es menor o igual a lo asignado (sin horas extra)', function () {
    // Creamos un usuario sin horario asignado (se usará el valor por defecto: 7 horas)
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Trabajo de 7 horas exactas: de 09:00 a 16:00
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-10 09:00:00',
        'check_out'     => '2025-05-10 16:00:00',
        'pause_minutes' => 0,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // Convertimos a float antes de comparar para evitar discrepancias de tipo
    expect((float)$workLog->ordinary_hours)->toBe(7.00);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
    expect((float)$workLog->overtime_hours)->toBe(0.00);
});

it('calcula correctamente las horas cuando se trabaja de más y se utiliza pausa definida', function () {
    // Usuario fulltime sin horario asignado (default 7 horas)
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Se trabaja de 09:00 a 18:00 (9 horas totales = 540 minutos)
    // con una pausa definida de 30 minutos entre 12:00 y 12:30
    $workLog = WorkLog::create([
        'user_id'     => $user->id,
        'check_in'    => '2025-05-10 09:00:00',
        'check_out'   => '2025-05-10 18:00:00',
        'pause_start' => '2025-05-10 12:00:00',
        'pause_end'   => '2025-05-10 12:30:00',
    ]);

    // Cálculo:
    // Total sin pausa: 540 minutos; pausa = 30 → trabajo neto = 510 minutos.
    // Valor asignado default = 7 * 60 = 420 minutos.
    // Exceso = 510 - 420 = 90 minutos → overtime = 90/60 = 1.5
    $workLog->calculateHours();
    $workLog->refresh();

    expect((float)$workLog->ordinary_hours)->toBe(7.00);
    expect((float)$workLog->overtime_hours)->toBe(1.50);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
});

it('calcula correctamente las horas cuando hay un horario asignado al usuario', function () {
    // Creamos un usuario fulltime y le asignamos un horario (por ejemplo, 8 horas para el lunes)
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Se asume que el usuario tiene la relación workSchedule y se puede crear el schedule
    $user->workSchedule()->create([
        'monday_hours' => 8, // Horas asignadas para el lunes
    ]);

    // Seleccionamos una fecha de lunes, por ejemplo el 12 de mayo de 2025
    // Trabajo de 09:00 a 18:00 (9 horas totales = 540 minutos); sin pausa
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-12 09:00:00',
        'check_out'     => '2025-05-12 18:00:00',
        'pause_minutes' => 0,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // Cálculo:
    // Horas asignadas según el schedule: 8 → 480 minutos.
    // Trabajo total: 540 minutos; exceso = 540 - 480 = 60 minutos → overtime = 1 hora
    expect((float)$workLog->ordinary_hours)->toBe(8.00);
    expect((float)$workLog->overtime_hours)->toBe(1.00);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
});
