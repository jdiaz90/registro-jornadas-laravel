<?php

use App\Models\WorkLog;
use App\Models\WorkLogAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Unit');

it('crea y almacena un registro de auditoría correctamente', function () {
    // Crear un registro de WorkLog para que la clave foránea sea válida
    $workLog = WorkLog::factory()->create();

    $audit = WorkLogAudit::create([
        'work_log_id'            => $workLog->id, // Usamos el id válido
        'old_check_in'           => '2025-05-10 09:00:00',
        'new_check_in'           => '2025-05-10 09:05:00',
        'old_check_out'          => '2025-05-10 17:00:00',
        'new_check_out'          => '2025-05-10 17:05:00',
        'old_hash'               => 'old_hash_value',
        'new_hash'               => 'new_hash_value',
        'updated_by'             => 2,
        'old_ordinary_hours'     => 7,
        'new_ordinary_hours'     => 7.5,
        'old_complementary_hours'=> 0,
        'new_complementary_hours'=> 0,
        'old_overtime_hours'     => 0,
        'new_overtime_hours'     => 0.5,
        'old_pause_start'        => '2025-05-10 12:00:00',
        'new_pause_start'        => '2025-05-10 12:05:00',
        'old_pause_end'          => '2025-05-10 12:30:00',
        'new_pause_end'          => '2025-05-10 12:35:00',
        'old_pause_minutes'      => 30,
        'new_pause_minutes'      => 30,
        'modification_reason'    => 'Corrección en registro',
    ]);

    // Verificar que los castings se hayan aplicado correctamente,
    // por ejemplo, que los campos de horas sean float y los de pausa integer.
    expect(is_float($audit->old_ordinary_hours))->toBeTrue();
    expect($audit->old_ordinary_hours)->toEqual(7.0);
    expect(is_int($audit->old_pause_minutes))->toBeTrue();
    expect($audit->old_pause_minutes)->toBe(30);
});
