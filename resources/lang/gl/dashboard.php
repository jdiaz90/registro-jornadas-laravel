<?php

return [
    'header' => 'Taboleiro',

    'welcome' => [
        'greeting'    => '¡Benvido, :name!',
        'description' => 'Explora a túa actividade e xestiona os teus rexistros dende aquí.',
    ],

    'cards' => [
        'work_logs' => [
            'title'       => 'Os meus Rexistros de Xornada',
            'description' => 'Revisa e xestiona os teus rexistros de entrada e saída.',
            'button'      => 'Ver Rexistros de Xornada',
            'count_label' => 'Rexistros',
        ],
        'profile' => [
            'title'       => 'O meu Perfil',
            'description' => 'Actualiza os teus datos persoais e configura a túa conta.',
            'button'      => 'Editar Perfil',
        ],
        'statistics' => [
            'title'        => 'Estatísticas',
            'description'  => 'Aquí poderías amosar datos relevantes, como o total de horas rexistradas ou indicadores de actividade.',
            'data_counter' => ':count Horas Rexistradas',
        ],
        'calendar' => [
            'title'       => 'Calendario',
            'description' => 'Visualiza o teu calendario anual e consulta os rexistros día a día.',
            'button'      => 'Ver Calendario',
        ],
        'export_report' => [
            'title'       => 'Exportar Informe',
            'description' => 'Descarga os teus rexistros de entrada e saída en formato Excel.',
            'button'      => 'Descargar Excel',
        ],
        'verify_record' => [
            'title'       => 'Verificar Rexistro',
            'description' => 'Verifica a integridade dos teus rexistros introducindo o código hash.',
            'button'      => 'Verificar Rexistro',
        ],
    ],
];
