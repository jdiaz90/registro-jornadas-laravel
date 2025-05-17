<?php

return [

    // Textos xerais do panel de administración
    'admin_panel'        => 'Panel de Administración',
    'welcome'            => '¡Benvido, Administrador :name!',
    'description'        => 'Accede ó panel para xestionar usuarios, revisar rexistros e obter estatísticas do sistema.',

    // Tarxetas/datos do dashboard
    'user_management' => [
        'title'       => 'Xestión de Utilizadores',
        'description' => 'Administra os utilizadores, revisa perfiles e actualiza datos.',
        'button'      => 'Ver Utilizadores',
    ],
    'work_logs' => [
        'title'       => 'Rexistros de Xornada',
        'description' => 'Consulta e filtra os work logs dos utilizadores.',
        'button'      => 'Ver Work Logs',
        'edit' => [
            'check_in_label'            => 'Entrada',
            'check_out_label'           => 'Saída',
            'pause_start_label'         => 'Inicio da pausa',
            'pause_end_label'           => 'Fin da pausa',
            'ordinary_hours_label'      => 'Horas ordinarias',
            'complementary_hours_label' => 'Horas complementarias',
            'overtime_hours_label'      => 'Horas extras',
            'pause_minutes_label'       => 'Minutos da pausa',
            'modification_reason_label' => 'Motivo da modificación',
        ],
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
    'create_user' => [
        'title'       => 'Crear Utilizador',
        'description' => 'Completa o formulario para rexistrar un novo utilizador no sistema',
        'button'      => 'Rexistrar Utilizador',
    ],

    // Textos específicos para utilizadores (listado, ficha, creación e edición)
    'users' => [
        // Vista de listado (index)
        'list_title'          => 'Listado de Utilizadores',
        'search_placeholder'  => 'Buscar por nome ou correo',
        'search_button'       => 'Buscar',
        'table' => [
            'id'    => 'ID',
            'name'  => 'Nome',
            'email' => 'Correo',
            'role'  => 'Rol',
            'actions' => 'Accións',
        ],
        'empty'               => 'Non se atoparon utilizadores.',
        'edit'               => 'Editar',
        'edit_tooltip'       => 'Editar usuario',

        // Vista de ficha (show)
        'show' => [
            'title'              => 'Ficha do Utilizador: :name',
            'back_to_list'       => 'Volver ó listado',
            'info_title'         => 'Información do Utilizador',
            'labels'             => [
                'name'          => 'Nome',
                'email'         => 'Correo',
                'role'          => 'Rol',
                'contract_type' => 'Tipo de Contrato',
            ],
            'work_schedule_title'=> 'Horario de Traballo',
            'no_work_schedule'   => 'O utilizador non ten horario de xornada asignado.',
            'work_logs_title'    => 'Historial de Rexistros de Xornada',
            'edit_button'        => 'Editar',
            'schedule' => [
                'day'            => 'Día',
                'assigned_hours' => 'Horas asignadas',
                'break_minutes'  => 'Minutos de descanso',
                'total'          => 'Total',
            ],
        ],

        // Vista de creación (create)
        'create' => [
            'header'     => 'Crear Utilizador',
            'info_title' => 'Información do Utilizador',
            'form'       => [
                'name'                  => 'Nome',
                'email'                 => 'Correo electrónico',
                'password'              => 'Contrasinal',
                'password_confirmation' => 'Confirmar contrasinal',
                'role'                  => 'Rol',
                'contract_type'         => 'Tipo de Contrato',
                'save_changes'          => 'Gardar cambios',
                'options'               => [
                    'user'      => 'Utilizador',
                    'admin'     => 'Administrador',
                    'fulltime'  => 'Tempo completo',
                    'parttime'  => 'Tempo parcial',
                ],
            ],
            'schedule' => [
                'title' => 'Horario de Traballo',
                'hours' => 'Horas asignadas',
            ],
        ],

        // Vista de edición (edit)
        'edit' => [
            'header'       => 'Editar Utilizador: :name',
            'back_to_list' => 'Volver ó listado',
            'info_title'   => 'Información do Utilizador',
            'form'         => [
                'name'          => 'Nome',
                'email'         => 'Correo electrónico',
                'role'          => 'Rol',
                'contract_type' => 'Tipo de Contrato',
                'save_changes'  => 'Gardar cambios',
                'options'       => [
                    'user'      => 'Utilizador',
                    'admin'     => 'Administrador',
                    'fulltime'  => 'Tempo completo',
                    'parttime'  => 'Tempo parcial',
                ],
            ],
            'schedule' => [
                'title' => 'Horario de Traballo',
                'hours' => 'Horas asignadas',
            ],
        ],
    ],

    // Días da semana
    'weekdays' => [
        'monday'    => 'Luns',
        'tuesday'   => 'Martes',
        'wednesday' => 'Mércores',
        'thursday'  => 'Xoves',
        'friday'    => 'Venres',
        'saturday'  => 'Sábado',
        'sunday'    => 'Domingo',
    ],
];
