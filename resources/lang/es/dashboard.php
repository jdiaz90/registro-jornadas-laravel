<?php

return [
    // Texto del encabezado principal
    'header' => 'Dashboard',

    // Sección de bienvenida
    'welcome' => [
        'greeting'    => '¡Bienvenido, :name!',
        'description' => 'Explora tu actividad y gestiona tus registros desde aquí.',
    ],

    // Tarjetas (cards) del dashboard
    'cards' => [
        'work_logs' => [
            'title'       => 'Mis Work Logs',
            'description' => 'Revisa y gestiona tus registros de entrada y salida.',
            'button'      => 'Ver Work Logs',
            // Etiqueta que se mostrará junto al contador (en este ejemplo se muestra "Logs")
            'count_label' => 'Logs',
        ],
        'profile' => [
            'title'       => 'Mi Perfil',
            'description' => 'Actualiza tus datos personales y configura tu cuenta.',
            'button'      => 'Editar Perfil',
        ],
        'statistics' => [
            'title'        => 'Estadísticas',
            'description'  => 'Aquí podrías mostrar datos relevantes, como total de horas registradas o indicadores de actividad.',
            // El :count se reemplazará con el número de horas, por ejemplo
            'data_counter' => ':count Horas Registradas',
        ],
        'calendar' => [
            'title'       => 'Calendario',
            'description' => 'Visualiza tu calendario anual y consulta los registros día a día.',
            'button'      => 'Ver Calendario',
        ],
        'export_report' => [
            'title'       => 'Exportar Informe',
            'description' => 'Descarga tus registros de entrada y salida en formato Excel.',
            'button'      => 'Descargar Excel',
        ],
        'verify_record' => [
            'title'       => 'Verificar Registro',
            'description' => 'Verifica la integridad de tus registros ingresando el código hash.',
            'button'      => 'Verificar Registro',
        ],
    ],
];
