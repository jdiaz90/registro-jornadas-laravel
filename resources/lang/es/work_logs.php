<?php

return [
    'edit' => [
        'header'             => 'Editar Registro #:id',
        'check_in_label'     => 'Entrada',
        'check_out_label'    => 'Salida',
        'current_hash_label' => 'Hash actual',
        'save_changes'       => 'Guardar cambios',
    ],

    'index' => [
        'header' => 'Registro de Jornada',
        'check_in' => [
            'title'       => 'Registrar Entrada',
            'description' => 'Inicia tu jornada registrando la entrada.',
            'button'      => 'Entrada',
        ],
        'check_out' => [
            'title'       => 'Registrar Salida',
            'description' => 'Termina tu jornada registrando la salida.',
            'button'      => 'Salida',
        ],
        'history_title' => 'Historial de Registros',
    ],

    'show' => [
        'header' => 'Detalle del Registro #:id',
    ],

    // Sección para la vista verify.blade.php
    'verify' => [
        'header' => 'Verificar Registro',
        
        'success' => [
            'title'    => '¡Registro Auténtico!',
            'check_in' => 'Entrada',
            'check_out'=> 'Salida',
            'user'     => 'Usuario'
        ],

        'failure' => [
            'title'   => 'Código Incorrecto',
            'message' => 'El código hash ingresado no coincide con el registro solicitado.',
        ],
        
        'form' => [
            'id_label'        => 'ID del Registro:',
            'id_placeholder'  => 'Ingrese el ID del registro',
            'hash_label'      => 'Código Hash:',
            'hash_placeholder'=> 'Ingrese el código hash',
            'button'          => 'Verificar'
        ],
    ],

    // Otras secciones que ya tengas...
];
