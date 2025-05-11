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
            'pause_start'         => 'Inicio Pausa',
            'pause_end'           => 'Fin Pausa',
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
            'modified_fields' => 'Campo(s) Modificado',
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
            'label_month'   => 'Mes',
            'label_year'    => 'Ano',
            'button_filter' => 'Filtrar',
            'option_all'    => 'Todos',
        ],
        'table' => [
            'id'                  => 'ID',
            'check_in'            => 'Entrada',
            'check_out'           => 'Saída',
            'pause_start'         => 'Inicio Pausa',
            'pause_end'           => 'Fin Pausa',
            'ordinary_hours'      => 'Horas Ordinarias',
            'complementary_hours' => 'Horas Complementarias',
            'overtime_hours'      => 'Horas Extras',
            'pause_minutes'       => 'Minutos de Pausa',
            'hash'                => 'Hash',
            'no_records'          => 'Aínda non hai rexistros.',
        ],
        'ongoing' => 'En curso',
        'pending' => 'Pendente',
    ],
    
    // Etiquetas para os meses (gallego)
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

    // Aquí podes engadir traduccións para outros compoñentes a futuro
];
