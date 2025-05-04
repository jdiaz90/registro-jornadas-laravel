<?php

return [

    // Textos xerais do panel de administración
    'admin_panel'        => 'Panel de Administración',
    'welcome'            => 'Benvido, Administrador :name!',
    'description'        => 'Accede ó panel para xestionar usuarios, revisar rexistros e obter estatísticas do sistema.',

    // Tarxetas/datos do dashboard
    'user_management' => [
        'title'       => 'Xestión de Utilizadores',
        'description' => 'Administra os utilizadores, revisa perfiles e actualiza datos.',
        'button'      => 'Ver Utilizadores',
    ],
    'work_logs' => [
        'title'       => 'Rexistros de Xornada',
        'description' => 'Consulta e filtra os rexistros de xornada dos usuarios.',
        'button'      => 'Ver Rexistros de Xornada',
    ],
    'global_statistics' => [
        'title'       => 'Estatísticas Globais',
        'description' => 'Mostra datos relevantes e totais do sistema.',
        'button'      => 'Ver Estatísticas',
    ],
    'calendar' => [
        'title'       => 'Calendario',
        'description' => 'Consulta o calendario de actividades e rexistros.',
        'button'      => 'Ver Calendario',
    ],
    'reports' => [
        'title'       => 'Exportar Informes',
        'description' => 'Descarga informes en formato Excel para análise.',
        'button'      => 'Descargar Excel',
    ],
    'settings' => [
        'title'       => 'Configuracións',
        'description' => 'Accede aos axustes avanzados do sistema e administra permisos.',
        'button'      => 'Configurar',
    ],

    // Textos específicos para usuarios (listado e ficha)
    'users' => [
        // Vista de listado (index)
        'list_title'          => 'Listado de Utilizadores',
        'search_placeholder'  => 'Buscar por nome ou correo',
        'search_button'       => 'Buscar',
        'table' => [
            'id'      => 'ID',
            'name'    => 'Nome',
            'email'   => 'Correo',
            'role'    => 'Rol',
        ],
        'empty'               => 'Non se atoparon utilizadores.',

        // Vista de ficha (show)
        'show' => [
            'title'           => 'Ficha do Utilizador: :name',
            'back_to_list'    => 'Volver ó listado',
            'info_title'      => 'Información do Utilizador',
            'labels' => [
                'name'  => 'Nome',
                'email' => 'Correo',
                'role'  => 'Rol',
            ],
            'work_logs_title' => 'Historial de Rexistros de Xornada',
        ],
    ],
];
