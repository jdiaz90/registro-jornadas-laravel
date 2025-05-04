<?php

return [
    'alert' => [
        'close' => 'Cerrar',
    ],

    'work_log_detail' => [
        'current_info_title'   => 'Información Actual',
        'label' => [
            'user'       => 'Usuario:',
            'hash'       => 'Hash',
            'check_in'   => 'Entrada',
            'check_out'  => 'Salida',
            'created_at' => 'Creado:',
            'updated_at' => 'Actualizado:',
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
            'id'        => 'ID',
            'check_in'  => 'Entrada',
            'check_out' => 'Salida',
            'hash'      => 'Hash',
            'no_records'=> 'Aún no hay registros.',
        ],
        'ongoing' => 'En curso',
        'pending' => 'Pendiente',
    ],
    
    // Aquí puedes agregar traducciones para otros componentes a futuro
];
