<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs; // <-- Importa la función actingAs

uses(RefreshDatabase::class);

it('muestra el listado de usuarios', function () {
    // Crear un usuario administrador
    $admin = User::factory()->create(['role' => 'admin']);
    
    // Crear varios usuarios para el listado
    User::factory()->count(5)->create();
    
    actingAs($admin);
    
    $response = $this->get(route('admin.users.index'));
    
    $response->assertOk();
    $response->assertViewHas('users');
});

it('muestra la ficha de usuario con los registros de trabajo', function () {
    // Crear un usuario normal y un usuario administrador
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    
    actingAs($admin);
    
    $response = $this->get(route('admin.users.show', $user->id));
    
    $response->assertOk();
    $response->assertViewHasAll(['user', 'logs']);
});

it('muestra el formulario de edición de un usuario', function () {
    // Crear usuario a editar y un admin
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    
    actingAs($admin);
    
    $response = $this->get(route('admin.users.edit', $user->id));
    
    $response->assertOk();
    $response->assertViewHas('user');
});

it('actualiza un usuario correctamente', function () {
    // Crear usuario y admin
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    
    actingAs($admin);
    
    // Datos de actualización: se debe incluir además el array para el work_schedule
    $newData = [
        'name' => 'Nuevo Nombre',
        'email' => 'nuevoemail@example.com',
        'role' => 'user',
        'contract_type' => 'fulltime',
        'work_schedule' => [
            'monday_hours'    => 8,
            'tuesday_hours'   => 8,
            'wednesday_hours' => 8,
            'thursday_hours'  => 8,
            'friday_hours'    => 8,
            'saturday_hours'  => 0,
            'sunday_hours'    => 0,
        ],
    ];
    
    $response = $this->put(route('admin.users.update', $user->id), $newData);
    
    $response->assertRedirect(route('admin.users.show', $user->id));
    $response->assertSessionHas('status', 'Usuario actualizado correctamente.');
    
    // Verificamos que la base de datos contiene los nuevos datos
    $this->assertDatabaseHas('users', [
        'id'            => $user->id,
        'name'          => 'Nuevo Nombre',
        'email'         => 'nuevoemail@example.com',
        'role'          => 'user',
        'contract_type' => 'fulltime',
    ]);
});
