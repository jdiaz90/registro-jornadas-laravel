<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('breadcrumbs.home'), url('/'));
});

// PANEL DE CONTROL DEL USUARIO
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('breadcrumbs.dashboard'), route('dashboard'));
});

// PERFIL DEL USUARIO (edición)
Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumbs.profile'), route('profile.edit'));
});

// REGISTROS DE JORNADA: listado
Breadcrumbs::for('work_logs.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumbs.work_logs_index'), route('work_logs.index'));
});

// REGISTRO DE JORNADA: ver detalle de un registro
Breadcrumbs::for('work_logs.show', function (BreadcrumbTrail $trail, $workLog) {
    $trail->parent('work_logs.index');
    if (!is_object($workLog)) {
        $workLog = \App\Models\WorkLog::find($workLog);
    }
    $trail->push(str_replace(':id', $workLog->id, __('breadcrumbs.work_logs_show')), route('work_logs.show', $workLog));
});

// CALENDARIO
Breadcrumbs::for('calendar.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumbs.calendar'), route('calendar.index'));
});

// VERIFICAR REGISTRO DE JORNADA
Breadcrumbs::for('work_logs.verify', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('breadcrumbs.verify'), route('work_logs.verify'));
});

// PROCESO DE VERIFICACIÓN
Breadcrumbs::for('work_logs.verify.process', function (BreadcrumbTrail $trail) {
    $trail->parent('work_logs.verify');
    $trail->push(__('breadcrumbs.verify_process'), route('work_logs.verify.process'));
});


// MIGAS PARA LAS RUTAS DE ADMINISTRACIÓN

// PANEL ADMINISTRATIVO
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('breadcrumbs.admin_dashboard'), route('admin.dashboard'));
});

// Administración de Usuarios – Listado
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('breadcrumbs.admin_users_index'), route('admin.users.index'));
});

// Administración de Usuarios – Crear
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push(__('breadcrumbs.admin_users_create'), route('admin.users.create'));
});

// Administración de Usuarios – Mostrar detalle
Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.index');
    if (!is_object($user)) {
        $user = \App\Models\User::find($user);
    }
    $trail->push($user->name, route('admin.users.show', $user));
});

// Administración de Usuarios – Editar
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.show', $user);
    $trail->push(__('breadcrumbs.admin_users_edit'), route('admin.users.edit', $user));
});

// Administración de Registros de Jornada – Editar
Breadcrumbs::for('admin.work_logs.edit', function (BreadcrumbTrail $trail, $workLog) {
    $trail->parent('admin.dashboard');
    $trail->push(__('breadcrumbs.admin_work_logs_edit'), route('admin.work_logs.edit', $workLog));
});

// Administración de Registros de Jornada – Listado
Breadcrumbs::for('admin.work_logs.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('breadcrumbs.admin_work_logs_index'), route('admin.work_logs.index'));
});


// Auditorías de Registros de Jornada (índice)
Breadcrumbs::for('admin.work_log_audits.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('breadcrumbs.admin_work_log_audits_index'), route('admin.work_log_audits.index'));
});
