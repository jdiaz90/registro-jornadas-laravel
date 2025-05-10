<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra el dashboard exclusivo para administradores', function () {
    // Simulamos un usuario administrador para acceder a la ruta protegida
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);
    
    // Se asume que la ruta definida es '/admin/dashboard'
    $response = $this->get('/admin/dashboard');

    // Verificamos que la respuesta sea status 200 y que se cargue la vista "admin.dashboard"
    $response->assertStatus(200);
    $response->assertViewIs('admin.dashboard');
});
