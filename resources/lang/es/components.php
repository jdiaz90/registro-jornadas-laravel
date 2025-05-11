<?php

return [
    'alert' => [
        'close' => 'Cerrar',
    ],

    'work_log_detail' => [
        'current_info_title'   => 'Información Actual',
        'label' => [
            'user'                => 'Usuario',
            'hash'                => 'Hash',
            'check_in'            => 'Entrada',
            'check_out'           => 'Salida',
            'pause_start'         => 'Inicio Pausa',
            'pause_end'           => 'Fin Pausa',
            'ordinary_hours'      => 'Horas Ordinarias',
            'complementary_hours' => 'Horas Complementarias',
            'overtime_hours'      => 'Horas Extras',
            'pause_minutes'       => 'Minutos de Pausa',
            'created_at'          => 'Creado',
            'updated_at'          => 'Actualizado',
            'modification_reason' => 'Motivo de la modificación',
        ],
        'audit_history_title'  => 'Historial de Cambios',
        'audit_empty'          => 'No se encontraron cambios para este registro.',
        'table' => [
            'date'            => 'Fecha',
            'modified_fields' => 'Campo(s) Modificado',
            'old_value'       => 'Valor Anterior',
            'new_value'       => 'Valor Nuevo',
            'updated_by'      => 'Actualizado Por',
        ],
        'edit_button'  => 'Editar Registro',
        'print_button' => 'Imprimir Registro',
    ],
    
    'work_logs_table' => [
        'title' => 'Historial de Registros',
        'filter' => [
            'label_month'   => 'Mes',
            'label_year'    => 'Año',
            'button_filter' => 'Filtrar',
            'option_all'    => 'Todos',
        ],
        'table' => [
            'id'                  => 'ID',
            'check_in'            => 'Entrada',
            'check_out'           => 'Salida',
            'pause_start'         => 'Inicio Pausa',
            'pause_end'           => 'Fin Pausa',
            'ordinary_hours'      => 'Horas Ordinarias',
            'complementary_hours' => 'Horas Complementarias',
            'overtime_hours'      => 'Horas Extras',
            'pause_minutes'       => 'Minutos de Pausa',
            'hash'                => 'Código Hash',
            'no_records'          => 'Aún no hay registros.',
        ],
        'ongoing' => 'En curso',
        'pending' => 'Pendiente',
    ],
    
    // Etiquetas para los meses
    'months' => [
        '1'  => 'Enero',
        '2'  => 'Febrero',
        '3'  => 'Marzo',
        '4'  => 'Abril',
        '5'  => 'Mayo',
        '6'  => 'Junio',
        '7'  => 'Julio',
        '8'  => 'Agosto',
        '9'  => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ],

    // Aquí puedes agregar traducciones para otros componentes a futuro
];
