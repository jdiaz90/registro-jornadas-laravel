<?php

use App\Models\User;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Usamos TestCase y RefreshDatabase para que cada test se ejecute en un entorno limpio.
uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

// Test 1: Genera y verifica el hash correctamente.
it('genera y verifica el hash correctamente', function () {
    // Creamos un usuario.
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

// Test 2: Calcula correctamente las horas cuando lo trabajado es menor o igual a lo asignado (sin horas extra).
it('calcula correctamente las horas cuando lo trabajado es menor o igual a lo asignado (sin horas extra)', function () {
    // Usuario fulltime sin schedule definido: se usará el valor por defecto (7 horas).
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Jornada exacta de 7 horas: de 09:00 a 16:00 (7 x 60 = 420 minutos).
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-10 09:00:00',
        'check_out'     => '2025-05-10 16:00:00',
        'pause_minutes' => 0,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // Se esperan 7 horas ordinarias y 0 en las demás categorías.
    expect((float)$workLog->ordinary_hours)->toBe(7.00);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
    expect((float)$workLog->overtime_hours)->toBe(0.00);
});

// Test 3: Calcula correctamente las horas cuando se trabaja de más y se utiliza pausa definida (usuario fulltime).
it('calcula correctamente las horas cuando se trabaja de más y se utiliza pausa definida (usuario fulltime)', function () {
    // Usuario fulltime sin schedule definido (se usa default 7 horas).
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Jornada: de 09:00 a 18:00 (9 horas totales = 540 minutos) con pausa definida de 30 minutos (de 12:00 a 12:30).
    $workLog = WorkLog::create([
        'user_id'     => $user->id,
        'check_in'    => '2025-05-10 09:00:00',
        'check_out'   => '2025-05-10 18:00:00',
        'pause_start' => '2025-05-10 12:00:00',
        'pause_end'   => '2025-05-10 12:30:00',
    ]);

    // Cálculo:
    //   Total sin pausa: 540 minutos.
    //   Pausa: 30 minutos.
    //   Trabajo neto: 510 minutos.
    //   Default asignado: 7 horas → 420 minutos.
    //   Exceso: 510 - 420 = 90 minutos, que para usuario fulltime se asignan a overtime (90/60 = 1.50 horas).
    $workLog->calculateHours();
    $workLog->refresh();

    expect((float)$workLog->ordinary_hours)->toBe(7.00);
    expect((float)$workLog->overtime_hours)->toBe(1.50);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
});

// Test 4: Calcula correctamente las horas cuando hay un horario asignado al usuario (fulltime).
it('calcula correctamente las horas cuando hay un horario asignado al usuario (fulltime)', function () {
    $user = User::factory()->create([
        'contract_type' => 'fulltime',
    ]);

    // Se asigna un workSchedule para el lunes: 8 horas asignadas.
    $user->workSchedule()->create([
        'monday_hours' => 8,
    ]);

    // Seleccionamos una fecha de lunes, por ejemplo, el 12 de mayo de 2025.
    // Jornada: de 09:00 a 18:00 (540 minutos) sin pausa.
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-12 09:00:00',
        'check_out'     => '2025-05-12 18:00:00',
        'pause_minutes' => 0,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // Asignado según el schedule: 8 horas = 480 minutos.
    // Trabajo total: 540 minutos; exceso: 540 - 480 = 60 minutos, que para fulltime se asigna a overtime: 60/60 = 1.00.
    expect((float)$workLog->ordinary_hours)->toBe(8.00);
    expect((float)$workLog->overtime_hours)->toBe(1.00);
    expect((float)$workLog->complementary_hours)->toBe(0.00);
});

// Test 5: Calcula correctamente las horas cuando un usuario parttime trabaja de más.
// En este test, el usuario parttime tiene un schedule definido sólo para Monday.
// Para una fecha en la que no esté definido (por ejemplo, un sábado), se toma el valor real del schedule, que en este caso es nulo,
// lo que implica que se use 0 horas asignadas (ya que *si está definido, el 0 es válido*).
// Sin embargo, en nuestro test, queremos que en ausencia de schedule se use el default y separar el comportamiento para usuario parttime.
it('calcula correctamente las horas cuando un usuario parttime trabaja de más', function () {
    $user = User::factory()->create([
        'contract_type' => 'parttime',
    ]);

    // Creamos un schedule definido sólo para monday_hours; no se definen los demás campos (no se usa default, se respeta el valor nulo/0).
    // Para este test, queremos evaluar el caso en que, al no existir el valor para el día consultado, se asuma 0 horas asignadas.
    $user->workSchedule()->create([
        'monday_hours' => 7,
    ]);

    // Jornada: de 09:00 a 18:00 en una fecha que NO es lunes (por ejemplo, 10 de mayo de 2025, que es sábado).
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-10 09:00:00',
        'check_out'     => '2025-05-10 18:00:00',
        'pause_minutes' => 0,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // En este caso, la lógica es:
    //   Si el usuario tiene schedule pero para el día de la semana (sábado) no está definido, usar el valor obtenido (null se convierte a 0),
    //   entonces, el usuario tiene 0 horas asignadas ese día.
    // Como resultado, el cálculo sería:
    //   Trabajo total: 540 minutos.
    //   Asignado: 0 minutos (porque el schedule para sábado es 0, y ahora respetamos el 0).
    //   Exceso: 540 minutos.
    //   Para un usuario parttime, toda esa cantidad excedente se asignaría a complementary_hours, pero ordinary_hours queda en 0.
    // Si quieres que para días no definidos se use un default (por ejemplo, 7 horas), en ese caso deberías modificar la lógica.
    // Aquí se muestra el comportamiento según la nueva petición: Si el workSchedule existe y el valor es 0, se respeta el 0.
    expect((float)$workLog->ordinary_hours)->toBe(0.00);
    // Y, como todo el trabajo se considera extra para parttime, se asignaría a complementary_hours:
    expect((float)$workLog->complementary_hours)->toBe(9.00); // 540 minutos / 60
    expect((float)$workLog->overtime_hours)->toBe(0.00);
});

// Test 6: Utiliza pause_minutes cuando no se definen pause_start ni pause_end.
it('utiliza pause_minutes cuando no se definen pause_start ni pause_end', function () {
    $user = User::factory()->create([
        'contract_type' => 'parttime',
    ]);

    $user->workSchedule()->create([
        'monday_hours' => 7,
    ]);

    // Jornada: de 09:00 a 18:00 (540 minutos) con pause_minutes = 20.
    $workLog = WorkLog::create([
        'user_id'       => $user->id,
        'check_in'      => '2025-05-10 09:00:00',
        'check_out'     => '2025-05-10 18:00:00',
        'pause_minutes' => 20,
    ]);

    $workLog->calculateHours();
    $workLog->refresh();

    // Cálculo:
    //   Trabajo total: 540 - 20 = 520 minutos netos.
    //   Para el día consultado (sábado), si el schedule no define valor, se respeta 0.
    //   Entonces, ordinary_hours = 0, y todo el trabajo se considera extra para parttime.
    //   Exceso: 520 minutos → complementary_hours = 520/60 ≃ 8.67 horas.
    expect((float)$workLog->ordinary_hours)->toBe(0.00);
    expect((float)$workLog->complementary_hours)->toBe(round(520/60, 2));
    expect((float)$workLog->overtime_hours)->toBe(0.00);
});
