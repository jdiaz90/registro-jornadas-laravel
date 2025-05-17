<?php

return [
    // Textos de las vistas del módulo Work Logs
    'edit' => [
        'header'             => 'Edit Record #:id',
        'check_in_label'     => 'Check-in',
        'check_out_label'    => 'Check-out',
        'current_hash_label' => 'Current Hash',
        'save_changes'       => 'Save Changes',
        'pause_start_label'         => 'Start Pause',
        'pause_end_label'           => 'End Pause',
        'ordinary_hours_label'      => 'Ordinary Hours',
        'complementary_hours_label' => 'Complementary Hours',
        'overtime_hours_label'      => 'Overtime Hours',
        'pause_minutes_label'       => 'Pause Minutes',
        'modification_reason_label' => 'Modification Reason',
        'char_count'   => ':count/:max characters',
        'time_fields_title'       => 'Time Fields',
        'hour_fields_title'       => 'Calculated Hours',
    ],

    'index' => [
        'header' => 'Work Log',
        'check_in' => [
            'title'       => 'Log Check-in',
            'description' => 'Start your workday by logging your check-in.',
            'button'      => 'Check-in',
        ],
        'check_out' => [
            'title'       => 'Log Check-out',
            'description' => 'End your workday by logging your check-out.',
            'button'      => 'Check-out',
        ],
        'history_title' => 'Work Log History',
    ],

    'show' => [
        'header' => 'Record Detail #:id',
    ],

    // Sección para la vista verify.blade.php
    'verify' => [
        'header' => 'Verify Record',
        
        'success' => [
            'title'    => 'Authentic Record!',
            'check_in' => 'Check In',
            'check_out'=> 'Check Out',
            'user'     => 'User',
        ],

        'failure' => [
            'title'   => 'Incorrect Code',
            'message' => 'The hash code you entered does not match the requested record.',
        ],
        
        'form' => [
            'id_label'        => 'Record ID:',
            'id_placeholder'  => 'Enter the record ID',
            'hash_label'      => 'Hash Code:',
            'hash_placeholder'=> 'Enter the hash code',
            'button'          => 'Verify'
        ],
    ],

    // Mensajes usados, por ejemplo, en el controlador
    'messages' => [
        // Mensajes relacionados con el registro de entrada
        'check_in' => [
            'already_open' => 'You have already registered a check-in and have not completed check-out.',
            'success'      => 'Check-in registered successfully.',
        ],

        // Mensajes relacionados con el registro de salida
        'check_out' => [
            'no_open' => 'There is no open check-in record.',
            'success' => 'Check-out registered successfully.',
        ],

        // Mensajes relacionados con la actualización del registro
        'update' => [
            'no_changes' => 'No changes have been made to the record.',
            // Usa el placeholder :error para inyectar el mensaje específico de la excepción
            'save_error' => 'Error saving changes: :error',
            'success'    => 'Record updated and audited successfully.',
        ],

        // Mensaje para el control de autorización (por ejemplo, en el método show)
        'authorization' => [
            'unauthorized' => 'You are not authorized to view this record.',
        ],
    ],
];
