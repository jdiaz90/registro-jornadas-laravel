<?php

use App\Models\User;
use App\Models\WorkLog;
use App\Models\WorkSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Esto hace que se use la clase base TestCase y se refresque la base de datos en cada test
uses(Tests\TestCase::class, RefreshDatabase::class)->in('Unit');

it('crea un usuario con atributos fillables', function () {
    $user = User::factory()->create([
        'name'   => 'Usuario Prueba',
        'email'  => 'prueba@example.com',
        'locale' => 'es',
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Usuario Prueba');
    expect($user->email)->toBe('prueba@example.com');
    expect($user->locale)->toBe('es');
});

it('el usuario tiene muchos workLogs', function () {
    // Se asume que tienes definida la fábrica para WorkLog
    $user = User::factory()->has(WorkLog::factory()->count(3), 'workLogs')->create();

    expect($user->workLogs)->toHaveCount(3);
});

it('el usuario tiene una configuración de jornada', function () {
    // Se asume que tienes definida la fábrica para WorkSchedule
    $user = User::factory()->has(WorkSchedule::factory(), 'workSchedule')->create();

    expect($user->workSchedule)->not->toBeNull();
});
