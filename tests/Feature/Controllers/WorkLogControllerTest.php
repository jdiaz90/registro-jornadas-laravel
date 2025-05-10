<?php

use App\Models\User;
use App\Models\WorkLog;
use App\Models\WorkLogAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| WorkLogControllerTest
|--------------------------------------------------------------------------
|
| A continuación se realizan pruebas sobre los distintos métodos
| del WorkLogController:
|
| 1. index()             → Listado de logs (con o sin filtros)
| 2. checkIn()           → Registro de entrada
| 3. checkOut()          → Registro de salida
| 4. edit()              → Formulario de edición (para admin)
| 5. show()              → Mostrar detalle (para owner o admin; en otro caso aborta 403)
| 6. update()            → Actualización de registros de log
| 7. exportYearlyReport()→ Exportación de un reporte anual en Excel
|
*/

/** INDEX **/
it('muestra los work logs del usuario autenticado en index', function () {
    // Creamos un usuario y algunos registros para ese usuario y para otros
    $user = User::factory()->create();
    WorkLog::factory()->count(3)->create(['user_id' => $user->id]);
    WorkLog::factory()->count(2)->create(); // logs de otros usuarios

    $this->actingAs($user);
    $response = $this->get('/work-logs');

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.index');
    // Verificamos que todos los logs sean del usuario autenticado.
    $response->assertViewHas('logs', function ($logs) use ($user) {
        return $logs->getCollection()->every(fn($log) => $log->user_id === $user->id);
    });
});

it('filtra los work logs en index por año y mes', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Creamos logs en distintas fechas
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
    WorkLog::factory()->create([
       'user_id'   => $user->id,
       'check_in'  => '2024-05-15 09:00:00',
       'check_out' => '2024-05-15 17:00:00',
    ]);

    $response = $this->get('/work-logs?year=2025&month=5');
    $response->assertStatus(200);
    $response->assertViewHas('logs', function ($logs) {
        // Dado que se usa paginate() y no get(), accedemos a la colección interna.
        return $logs->getCollection()->every(fn($log) => date('n', strtotime($log->check_in)) == 5);
    });
});

/** CHECK-IN **/
it('permite registrar el check-in si no hay log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // No debe existir log abierto (check_out nulo)
    $response = $this->post('/work-logs/check-in');
    $response->assertSessionHas('success');

    expect(WorkLog::where('user_id', $user->id)->count())->toBe(1);
});

it('retorna error en check-in si ya hay un log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Creamos un log abierto (check_in asignado y check_out nulo)
    WorkLog::factory()->create([
        'user_id'  => $user->id,
        'check_in' => Carbon::now(),
        'check_out'=> null,
    ]);
    $response = $this->post('/work-logs/check-in');
    $response->assertSessionHas('error');
});

/** CHECK-OUT **/
it('permite registrar el check-out si existe log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
         'user_id'   => $user->id,
         'check_in'  => Carbon::now()->subHour(),
         'check_out' => null,
    ]);
    $response = $this->post('/work-logs/check-out');
    $response->assertSessionHas('success');

    $log->refresh();
    expect($log->check_out)->not->toBeNull();
});

it('retorna error en check-out si no hay log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/work-logs/check-out');
    $response->assertSessionHas('error');
});

/** EDIT **/
it('muestra el formulario de edición para un work log (edit) si el usuario es administrador', function () {
    // La ruta de edición se define en el grupo admin: '/admin/work-logs/{work_log}/edit'
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $workLog = WorkLog::factory()->create();
    $response = $this->get("/admin/work-logs/{$workLog->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.edit');
    $response->assertViewHas('workLog', fn($wl) => $wl->id === $workLog->id);
});

/** SHOW **/
it('muestra el detalle de un work log en show si el usuario es el dueño', function () {
    // Para el método show la ruta es '/work-logs/{id}'
    $user = User::factory()->create();
    $this->actingAs($user);

    $workLog = WorkLog::factory()->create(['user_id' => $user->id]);
    // Creamos algunos registros de auditoría asociados a este work log
    WorkLogAudit::factory()->count(2)->create(['work_log_id' => $workLog->id]);

    $response = $this->get("/work-logs/{$workLog->id}");
    $response->assertStatus(200);
    $response->assertViewIs('work_logs.show');
    $response->assertViewHas('workLog', fn($wl) => $wl->id === $workLog->id);
    $response->assertViewHas('audits', fn($audits) => $audits->count() > 0);
});

it('retorna 403 en show si el usuario no es admin ni el dueño del work log', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create(); // Usuario que no es admin ni dueño

    $workLog = WorkLog::factory()->create(['user_id' => $owner->id]);
    $this->actingAs($other);

    $response = $this->get("/work-logs/{$workLog->id}");
    $response->assertStatus(403);
});

/** UPDATE **/
it('actualiza un work log en update si se realizan cambios', function () {
    // La actualización es gestionada en el grupo admin: ruta PUT '/admin/work-logs/{work_log}'
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $workLog = WorkLog::factory()->create([
         'check_in'  => '2025-02-02 09:00:00',
         'check_out' => '2025-02-02 17:00:00',
         'pause_start' => null,
         'pause_end' => null,
         'ordinary_hours' => 7,
         'complementary_hours' => 0,
         'overtime_hours' => 0,
         'pause_minutes' => 0,
    ]);

    // Enviamos datos distintos para actualizar; por ejemplo, cambiamos check_in
    $newCheckIn = '2025-02-02 08:30:00';
    $data = [
        'check_in'            => $newCheckIn,
        'check_out'           => '2025-02-02 17:00:00',
        'pause_start'         => null,
        'pause_end'           => null,
        'ordinary_hours'      => 7,
        'complementary_hours' => 0,
        'overtime_hours'      => 0,
        'pause_minutes'       => 0,
        'modification_reason' => 'Actualización de prueba',
    ];

    $response = $this->put("/admin/work-logs/{$workLog->id}", $data);
    $response->assertSessionHas('success');

    $workLog->refresh();
    expect($workLog->check_in)->toBe($newCheckIn);
});

it('retorna error en update si no se detectan cambios', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $workLog = WorkLog::factory()->create([
         'check_in'  => '2025-02-02 09:00:00',
         'check_out' => '2025-02-02 17:00:00',
         'pause_start' => null,
         'pause_end' => null,
         'ordinary_hours' => 7,
         'complementary_hours' => 0,
         'overtime_hours' => 0,
         'pause_minutes' => 0,
    ]);

    // Enviamos exactamente los mismos datos que se tienen actualmente
    $existingCheckIn = Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i');
    $existingCheckOut = Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i');

    $data = [
        'check_in'            => $existingCheckIn,
        'check_out'           => $existingCheckOut,
        'pause_start'         => null,
        'pause_end'           => null,
        'ordinary_hours'      => 7,
        'complementary_hours' => 0,
        'overtime_hours'      => 0,
        'pause_minutes'       => 0,
        'modification_reason' => 'Sin cambios',
    ];

    $response = $this->put("/admin/work-logs/{$workLog->id}", $data);
    $response->assertSessionHas('error');

});

/** EXPORT YEARLY REPORT **/
it('exporta el reporte anual en Excel', function () {
    // Finge la descarga usando Excel::fake().
    Excel::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    $year = '2025';
    $response = $this->get("/work-logs/export/{$year}");

    Excel::assertDownloaded("work_logs_{$year}.xlsx", function ($export) use ($year) {
        return $export->getYear() == $year;
    });
});
