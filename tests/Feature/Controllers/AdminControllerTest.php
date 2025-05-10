<?php

use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Usamos TestCase y refrescamos la base de datos para traer un estado limpio.
uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra el listado de usuarios en la vista index', function () {
    // Creamos un usuario "admin" para poder acceder a las rutas protegidas.
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos varios usuarios para poblar el listado.
    User::factory()->count(30)->create();

    // Se asume que la ruta para el listado es '/admin/users'
    $response = $this->get('/admin/users');

    // Se espera que el status HTTP sea 200 (porque estamos autenticados)
    $response->assertStatus(200);
    $response->assertViewIs('admin.users.index');
    $response->assertViewHas('users');
});

it('filtra los usuarios mediante búsqueda en index', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos un usuario con un nombre específico.
    $usuarioBuscado = User::factory()->create(['name' => 'Juan Pérez']);
    // Creamos usuarios adicionales.
    User::factory()->count(5)->create();

    // Realizamos la petición a la ruta pasando un parámetro de búsqueda.
    $response = $this->get('/admin/users?search=Juan');

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.index');
    // Comprobamos que la variable "users" contenga al usuario buscado.
    $response->assertViewHas('users', function ($users) use ($usuarioBuscado) {
        return $users->contains('name', $usuarioBuscado->name);
    });
});

it('muestra la ficha del usuario y su historial de registros en show', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos un usuario normal.
    $user = User::factory()->create();

    // Creamos algunos registros de WorkLog para el usuario.
    WorkLog::factory()->count(3)->create(['user_id' => $user->id]);

    // Se asume que la ruta para ver la ficha del usuario es '/admin/users/{id}'
    $response = $this->get("/admin/users/{$user->id}");

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.show');
    $response->assertViewHas('user', function ($viewUser) use ($user) {
        return $viewUser->id === $user->id;
    });
    $response->assertViewHas('logs');
});

it('filtra el historial de registros en show por año y mes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos un usuario.
    $user = User::factory()->create();

    // Creamos dos WorkLogs para el usuario: uno en mayo y otro en junio de 2025.
    WorkLog::factory()->create([
        'user_id'   => $user->id,
        'check_in'  => '2025-05-15 09:00:00',
        'check_out' => '2025-05-15 17:00:00',
    ]);
    WorkLog::factory()->create([
        'user_id'   => $user->id,
        'check_in'  => '2025-06-10 09:00:00',
        'check_out' => '2025-06-10 17:00:00',
    ]);

    // Solicitamos filtrado por año 2025 y mes 05 (mayo).
    $response = $this->get("/admin/users/{$user->id}?year=2025&month=5");

    $response->assertStatus(200);
    $response->assertViewIs('admin.users.show');

    // Debido a que se usa paginate, $logs es un paginator. Se accede a la colección interna
    $response->assertViewHas('logs', function ($logs) {
        return $logs->getCollection()->every(function ($log) {
            return date('n', strtotime($log->check_in)) == 5;
        });
    });
});
