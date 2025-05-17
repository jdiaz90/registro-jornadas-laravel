<?php

return [

    // Textos generales del panel de administración
    'admin_panel'        => 'Panel de Administración',
    'welcome'            => '¡Bienvenido, Administrador :name!',
    'description'        => 'Accede al panel para gestionar usuarios, revisar registros y obtener estadísticas del sistema.',

    // Tarjetas/datos del dashboard
    'user_management' => [
        'title'       => 'Gestión de Usuarios',
        'description' => 'Administra usuarios, revisa perfiles y actualiza datos.',
        'button'      => 'Ver Usuarios',
    ],
    'work_logs' => [
        'title'       => 'Registros de Jornada',
        'description' => 'Consulta y filtra los work logs de los usuarios.',
        'button'      => 'Ver Work Logs',
        'edit' => [
            'check_in_label'            => 'Entrada',
            'check_out_label'           => 'Salida',
            'pause_start_label'         => 'Inicio de pausa',
            'pause_end_label'           => 'Fin de pausa',
            'ordinary_hours_label'      => 'Horas ordinarias',
            'complementary_hours_label' => 'Horas complementarias',
            'overtime_hours_label'      => 'Horas extras',
            'pause_minutes_label'       => 'Minutos de pausa',
            'modification_reason_label' => 'Motivo de la modificación',
        ],
    ],
    'global_statistics' => [
        'title'       => 'Estadísticas Globales',
        'description' => 'Muestra datos relevantes y totales del sistema.',
        'button'      => 'Ver Estadísticas',
    ],
    'calendar' => [
        'title'       => 'Calendario',
        'description' => 'Consulta el calendario de actividades y registros.',
        'button'      => 'Ver Calendario',
    ],
    'reports' => [
        'title'       => 'Exportar Informes',
        'description' => 'Descarga informes en formato Excel para análisis.',
        'button'      => 'Descargar Excel',
    ],
    'settings' => [
        'title'       => 'Configuraciones',
        'description' => 'Accede a ajustes avanzados del sistema y administra permisos.',
        'button'      => 'Configurar',
    ],
    'create_user' => [
        'title'       => 'Crear Usuario',
        'description' => 'Completa el formulario para registrar un nuevo usuario en el sistema',
        'button'      => 'Registrar usuario',
    ],

    // Textos específicos para usuarios (listado, ficha, creación y edición)
    'users' => [
        // Vista de listado (index)
        'list_title'          => 'Listado de Usuarios',
        'search_placeholder'  => 'Buscar por nombre o correo',
        'search_button'       => 'Buscar',
        'table' => [
            'id'    => 'ID',
            'name'  => 'Nombre',
            'email' => 'Correo',
            'role'  => 'Rol',
            'actions' => 'Acciones',
        ],
        'empty'               => 'No se encontraron usuarios.',
        'edit'               => 'Editar',
        'edit_tooltip'       => 'Editar usuario',

        // Vista de ficha (show)
        'show' => [
            'title'              => 'Ficha del Usuario: :name',
            'back_to_list'       => 'Volver al listado',
            'info_title'         => 'Información del Usuario',
            'labels'             => [
                'name'          => 'Nombre',
                'email'         => 'Email',
                'role'          => 'Rol',
                'contract_type' => 'Tipo de Contrato',
            ],
            'work_schedule_title'=> 'Horario de Trabajo',
            'no_work_schedule'   => 'El usuario no tiene horario de trabajo asignado.',
            'work_logs_title'    => 'Historial de Registros de Jornada',
            'edit_button'        => 'Editar',
            'schedule' => [
                'day'             => 'Día',
                'assigned_hours'  => 'Horas asignadas',
                'break_minutes'   => 'Minutos de descanso',
                'total'           => 'Total',
            ],
        ],

        // Vista de creación (create)
        'create' => [
            'header'     => 'Crear Usuario',
            'info_title' => 'Datos del Usuario',
            'form'       => [
                'name'                  => 'Nombre',
                'email'                 => 'Correo electrónico',
                'password'              => 'Contraseña',
                'password_confirmation' => 'Confirmar contraseña',
                'role'                  => 'Rol',
                'contract_type'         => 'Tipo de Contrato',
                'save_changes'          => 'Guardar cambios',
                'options'               => [
                    'user'     => 'Usuario',
                    'admin'    => 'Administrador',
                    'fulltime' => 'Tiempo Completo',
                    'parttime' => 'Tiempo Parcial',
                ],
            ],
            'schedule' => [
                'title' => 'Horario de Trabajo',
                'hours' => 'Horas asignadas',
            ],
        ],

        // Vista de edición (edit)
        'edit' => [
            'header'       => 'Editar Usuario: :name',
            'back_to_list' => 'Volver al listado',
            'info_title'   => 'Información del Usuario',
            'form'         => [
                'name'          => 'Nombre',
                'email'         => 'Correo electrónico',
                'role'          => 'Rol',
                'contract_type' => 'Tipo de Contrato',
                'save_changes'  => 'Guardar cambios',
                'options'       => [
                    'user'     => 'Usuario',
                    'admin'    => 'Administrador',
                    'fulltime' => 'Tiempo Completo',
                    'parttime' => 'Tiempo Parcial',
                ],
            ],
            'schedule' => [
                'title' => 'Horario de Trabajo',
                'hours' => 'Horas asignadas',
            ],
        ],
    ],

    // Días de la semana
    'weekdays' => [
        'monday'    => 'Lunes',
        'tuesday'   => 'Martes',
        'wednesday' => 'Miércoles',
        'thursday'  => 'Jueves',
        'friday'    => 'Viernes',
        'saturday'  => 'Sábado',
        'sunday'    => 'Domingo',
    ],
];
