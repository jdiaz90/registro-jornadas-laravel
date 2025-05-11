<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/*
|--------------------------------------------------------------------------
| Migas de Pan (Breadcrumbs)
|--------------------------------------------------------------------------
|
| Aquí definimos las migas de pan para varias secciones de la aplicación,
| usando el paquete diglactic/laravel-breadcrumbs.
|
*/

// MIGAS PARA LAS VISTAS PÚBLICAS

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Inicio', url('/'));
});

// PANEL DE CONTROL DEL USUARIO
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Panel de Control', route('dashboard'));
});

// PERFIL DEL USUARIO (edición)
Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Perfil', route('profile.edit'));
});

// REGISTROS DE JORNADA: listado
Breadcrumbs::for('work_logs.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Registros de Jornada', route('work_logs.index'));
});

// REGISTRO DE JORNADA: ver detalle de un registro
Breadcrumbs::for('work_logs.show', function (BreadcrumbTrail $trail, $workLog) {
    $trail->parent('work_logs.index');
    // Se muestra el ID del registro; puedes ajustar la etiqueta según tus necesidades
    $trail->push("Registro #{$workLog->id}", route('work_logs.show', $workLog));
});

// CALENDARIO
Breadcrumbs::for('calendar.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Calendario', route('calendar.index'));
});

// VERIFICAR REGISTRO DE JORNADA (si aplica)
Breadcrumbs::for('work_logs.verify', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Verificar Registro de Jornada', route('work_logs.verify'));
});


// MIGAS PARA LAS RUTAS DE ADMINISTRACIÓN

// PANEL ADMINISTRATIVO
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Panel Administrativo', route('admin.dashboard'));
});

// Administración de Usuarios – Listado
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Usuarios', route('admin.users.index'));
});

// Administración de Usuarios – Crear
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('Crear Usuario', route('admin.users.create'));
});

// Administración de Usuarios – Mostrar detalle
Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.show', $user));
});

// Administración de Usuarios – Editar
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.show', $user);
    $trail->push('Editar', route('admin.users.edit', $user));
});

// Administración de Registros de Jornada – Editar (ejemplo)
Breadcrumbs::for('admin.work_logs.edit', function (BreadcrumbTrail $trail, $workLog) {
    $trail->parent('admin.dashboard');
    $trail->push('Editar Registro de Jornada', route('admin.work_logs.edit', $workLog));
});

// Auditorías de Registros de Jornada (índice)
Breadcrumbs::for('admin.work_log_audits.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Auditorías de Registros de Jornada', route('admin.work_log_audits.index'));
});
