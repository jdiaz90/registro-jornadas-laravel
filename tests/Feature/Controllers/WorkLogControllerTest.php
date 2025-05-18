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
| En este archivo se realizan pruebas sobre los distintos métodos del 
| WorkLogController:
|
|  1. index()               → Listado de logs (con y sin filtros)
|  2. checkIn()             → Registro de entrada
|  3. checkOut()            → Registro de salida (incluyendo la finalización 
|                             automática de la pausa si está abierta)
|  4. edit()                → Formulario de edición (para admin)
|  5. show()                → Mostrar detalle (para owner o admin; de lo 
|                             contrario aborta 403)
|  6. update()              → Actualización de registros de log
|  7. exportYearlyReport()  → Exportación de reporte anual en Excel
|  8. Gestión de pausas:
|         - pauseStart()    → Iniciar la pausa
|         - pauseEnd()      → Finalizar la pausa
|
*/

/** INDEX **/
it('muestra los work logs del usuario autenticado en index', function () {
    $user = User::factory()->create();
    WorkLog::factory()->count(3)->create(['user_id' => $user->id]);
    WorkLog::factory()->count(2)->create(); // logs de otros usuarios

    $this->actingAs($user);
    $response = $this->get('/work-logs');

    $response->assertStatus(200);
    $response->assertViewIs('work_logs.index');
    $response->assertViewHas('logs', function ($logs) use ($user) {
        return $logs->getCollection()->every(fn($log) => $log->user_id === $user->id);
    });
});

it('filtra los work logs en index por año y mes', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

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
        return $logs->getCollection()->every(fn($log) => date('n', strtotime($log->check_in)) == 5);
    });
});

/** CHECK-IN **/
it('permite registrar el check-in si no hay log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/work-logs/check-in');
    $response->assertSessionHas('success');

    expect(WorkLog::where('user_id', $user->id)->count())->toBe(1);
});

it('retorna error en check-in si ya hay un log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

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
it('muestra el formulario de edición de un work log para admin', function () {
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
    $user = User::factory()->create();
    $this->actingAs($user);

    $workLog = WorkLog::factory()->create(['user_id' => $user->id]);
    WorkLogAudit::factory()->count(2)->create(['work_log_id' => $workLog->id]);

    $response = $this->get("/work-logs/{$workLog->id}");
    $response->assertStatus(200);
    $response->assertViewIs('work_logs.show');
    $response->assertViewHas('workLog', fn($wl) => $wl->id === $workLog->id);
    $response->assertViewHas('audits', fn($audits) => $audits->count() > 0);
});

it('retorna 403 en show si el usuario no es admin ni el dueño', function () {
    $owner = User::factory()->create(['role' => 'user']); // Usuario propietario con rol "user"
    $other = User::factory()->create(['role' => 'user']); // Usuario no admin ni propietario

    $workLog = WorkLog::factory()->create(['user_id' => $owner->id]);
    $this->actingAs($other);

    $response = $this->get("/work-logs/{$workLog->id}");
    $response->assertStatus(403);
});

/** UPDATE **/
it('actualiza un work log en update si se realizan cambios', function () {
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
    Excel::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    $year = '2025';
    $response = $this->get("/work-logs/export/{$year}");

    Excel::assertDownloaded("work_logs_{$year}.xlsx", function ($export) use ($year) {
        return $export->getYear() == $year;
    });
});

/** TESTS PARA LA GESTIÓN DE PAUSAS **/
// Test para iniciar pausa correctamente
it('permite iniciar una pausa si hay un log abierto y la pausa no está iniciada', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
        'user_id'     => $user->id,
        'check_in'    => Carbon::now()->subHour(),
        'check_out'   => null,
        'pause_start' => null,
        'pause_end'   => null,
    ]);

    $response = $this->post('/work-logs/pause-start');
    $response->assertSessionHas('success');
    $log->refresh();
    expect($log->pause_start)->not->toBeNull();
});

// Test para error al iniciar pausa sin log abierto
it('retorna error al intentar iniciar una pausa si no hay log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/work-logs/pause-start');
    $response->assertSessionHas('error');
});

// Test para error al iniciar pausa si ya está en curso
it('retorna error al intentar iniciar una pausa si ya se inició y no se finalizó', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
        'user_id'     => $user->id,
        'check_in'    => Carbon::now()->subHours(2),
        'check_out'   => null,
        'pause_start' => Carbon::now()->subMinutes(30),
        'pause_end'   => null,
    ]);

    $response = $this->post('/work-logs/pause-start');
    $response->assertSessionHas('error');
});

// Test para finalizar pausa correctamente
it('permite finalizar una pausa si ya se inició', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
        'user_id'     => $user->id,
        'check_in'    => Carbon::now()->subHours(2),
        'check_out'   => null,
        'pause_start' => Carbon::now()->subMinutes(30),
        'pause_end'   => null,
    ]);

    $response = $this->post('/work-logs/pause-end');
    $response->assertSessionHas('success');
    $log->refresh();
    expect($log->pause_end)->not->toBeNull();
    expect($log->pause_minutes)->toBeInt();
});

// Test para error al finalizar pausa sin log abierto
it('retorna error al intentar finalizar una pausa si no hay log abierto', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/work-logs/pause-end');
    $response->assertSessionHas('error');
});

// Test para error al finalizar pausa sin haberla iniciado
it('retorna error al intentar finalizar una pausa si no se ha iniciado', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
        'user_id'     => $user->id,
        'check_in'    => Carbon::now()->subHour(),
        'check_out'   => null,
        'pause_start' => null,
        'pause_end'   => null,
    ]);

    $response = $this->post('/work-logs/pause-end');
    $response->assertSessionHas('error');
});

// Test para finalización automática de pausa en check-out
it('finaliza automáticamente la pausa al registrar el check-out si la pausa está abierta', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $log = WorkLog::factory()->create([
        'user_id'     => $user->id,
        'check_in'    => Carbon::now()->subHours(2),
        'check_out'   => null,
        'pause_start' => Carbon::now()->subMinutes(45),
        'pause_end'   => null,
    ]);

    $response = $this->post('/work-logs/check-out');
    $response->assertSessionHas('success');

    $log->refresh();
    expect($log->check_out)->not->toBeNull();
    expect($log->pause_end)->not->toBeNull();
    expect($log->pause_minutes)->toBeInt();
    expect($log->pause_minutes)->toBeGreaterThanOrEqual(0);
});
