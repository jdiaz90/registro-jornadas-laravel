<?php

use App\Models\User;
use App\Models\WorkLogAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('muestra una lista paginada de registros de auditoría en index', function () {
    // Creamos un usuario con rol admin. Asegúrate de que el middleware "admin" verifique este campo.
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos algunos registros de auditoría
    WorkLogAudit::factory()->count(5)->create();

    // Realizamos la petición a la ruta protegida.
    $response = $this->get('/admin/work_log_audits');
    // Si sigues recibiendo 302, prueba desactivar temporalmente el middleware:
    // $response = $this->withoutMiddleware('admin')->get('/admin/work_log_audits');

    // Verificamos que la respuesta tenga status 200.
    $response->assertStatus(200);
    $response->assertViewIs('work_log_audits.index');
    $response->assertViewHas('audits');
});

it('muestra el detalle de un registro de auditoría en show', function () {
    // Creamos un usuario admin para que la ruta protegida permita el acceso.
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    // Creamos un registro de auditoría.
    $audit = WorkLogAudit::factory()->create();

    // Realizamos la petición GET a la ruta de detalle.
    $response = $this->get("/admin/work_log_audits/{$audit->id}");
    // Si en este test también sigues recibiendo 302, prueba:
    // $response = $this->withoutMiddleware('admin')->get("/admin/work_log_audits/{$audit->id}");

    // Verificamos que la respuesta tenga status 200.
    $response->assertStatus(200);
    $response->assertViewIs('work_log_audits.show');
    $response->assertViewHas('audit', function ($viewAudit) use ($audit) {
        return $viewAudit->id === $audit->id;
    });
});
