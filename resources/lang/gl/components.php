<?php

return [
    'alert' => [
        'close' => 'Pechar',
    ],

    'work_log_detail' => [
        'current_info_title'   => 'Información Actual',
        'label' => [
            'user'                => 'Utilizador',
            'hash'                => 'Hash',
            'check_in'            => 'Entrada',
            'check_out'           => 'Saída',
            'pause_start'         => 'Inicio de Pausa',
            'pause_end'           => 'Fin de Pausa',
            'ordinary_hours'      => 'Horas Ordinarias',
            'complementary_hours' => 'Horas Complementarias',
            'overtime_hours'      => 'Horas Extras',
            'pause_minutes'       => 'Minutos de Pausa',
            'created_at'          => 'Creado',
            'updated_at'          => 'Actualizado',
            'modification_reason' => 'Motivo da modificación',
        ],
        'audit_history_title'  => 'Historial de Alteracións',
        'audit_empty'          => 'Non se atoparon alteracións para este rexistro.',
        'table' => [
            'date'            => 'Data',
            'modified_fields' => 'Campo(s) Modificado(s)',
            'old_value'       => 'Valor Anterior',
            'new_value'       => 'Valor Novo',
            'updated_by'      => 'Actualizado Por',
        ],
        'edit_button'  => 'Editar Rexistro',
        'print_button' => 'Imprimir Rexistro',
    ],

    'work_logs_table' => [
        'title' => 'Historial de Rexistros',
        'filter' => [
            'label_start_date' => 'Data de inicio',
            'label_end_date'   => 'Data de fin',
            'label_user'       => 'Utilizador',
            'option_all'       => 'Todos',
            'button_filter'    => 'Filtrar',
            'label_month'      => 'Mes',
            'label_year'       => 'Ano',
        ],
        'table' => [
            'id'                  => 'ID',
            'user'                => 'Utilizador',
            'check_in'            => 'Entrada',
            'check_out'           => 'Saída',
            'pause_start'         => 'Inicio de Pausa',
            'pause_end'           => 'Fin de Pausa',
            'ordinary_hours'      => 'Horas Ordinarias',
            'complementary_hours' => 'Horas Complementarias',
            'overtime_hours'      => 'Horas Extras',
            'pause_minutes'       => 'Minutos de Pausa',
            'hash'                => 'Hash',
            'no_records'          => 'Non se atoparon rexistros.',
        ],
        'ongoing' => 'En curso',
        'pending' => 'Pendente',
    ],

    'work_logs' => [
        'messages' => [
            'invalid_date_range' => 'A data de inicio non pode ser posterior á data de fin.',
            'required_date_pair' => 'Debe introducir ambos valores, data de inicio e data de fin, para filtrar o rango.',
            'authorization'      => 'Non ten permiso para ver estes rexistros.',
        ],
    ],

    // Etiquetas para os meses
    'months' => [
        '1'  => 'Xaneiro',
        '2'  => 'Febreiro',
        '3'  => 'Marzo',
        '4'  => 'Abril',
        '5'  => 'Maio',
        '6'  => 'Xuño',
        '7'  => 'Xullo',
        '8'  => 'Agosto',
        '9'  => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Decembro',
    ],
];
