<?php

use App\Models\WorkSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Unit');

it('crea un WorkSchedule con atributos fillables', function () {
    // Creamos un usuario válido para que la clave foránea sea correcta.
    $user = User::factory()->create();

    // Datos de ejemplo para el WorkSchedule
    $attributes = [
        'user_id'                => $user->id, // Usar el id del usuario creado
        'monday_hours'           => 8,
        'monday_break_minutes'   => 30,
        'tuesday_hours'          => 8,
        'tuesday_break_minutes'  => 30,
        'wednesday_hours'        => 8,
        'wednesday_break_minutes'=> 30,
        'thursday_hours'         => 8,
        'thursday_break_minutes' => 30,
        'friday_hours'           => 8,
        'friday_break_minutes'   => 30,
        'saturday_hours'         => 0,
        'saturday_break_minutes' => 0,
        'sunday_hours'           => 0,
        'sunday_break_minutes'   => 0,
    ];

    // Crear el registro de WorkSchedule
    $workSchedule = WorkSchedule::create($attributes);

    // Verificar que los atributos se hayan guardado correctamente
    expect($workSchedule->monday_hours)->toBe(8);
    expect($workSchedule->monday_break_minutes)->toBe(30);
    expect($workSchedule->tuesday_hours)->toBe(8);
});

it('establece correctamente la relación con el usuario', function () {
    // Crear un usuario utilizando la fábrica
    $user = User::factory()->create();

    // Crear el WorkSchedule a través de la relación definida en el usuario
    $workSchedule = $user->workSchedule()->create([
        'monday_hours'           => 8,
        'monday_break_minutes'   => 30,
        'tuesday_hours'          => 8,
        'tuesday_break_minutes'  => 30,
        'wednesday_hours'        => 8,
        'wednesday_break_minutes'=> 30,
        'thursday_hours'         => 8,
        'thursday_break_minutes' => 30,
        'friday_hours'           => 8,
        'friday_break_minutes'   => 30,
        'saturday_hours'         => 0,
        'saturday_break_minutes' => 0,
        'sunday_hours'           => 0,
        'sunday_break_minutes'   => 0,
    ]);

    // Verificar que la relación retorna una instancia de User
    expect($workSchedule->user)->toBeInstanceOf(User::class);
});
