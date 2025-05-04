<?php

return [
    // Sección de vistas
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

    // Otros mensajes (usados en el controlador, por ejemplo)
    'messages' => [
        // Mensajes relacionados con el registro de entrada
        'check_in' => [
            'already_open' => 'Ya has registrado una entrada y no has completado la salida.',
            'success'      => 'Entrada registrada correctamente.',
        ],

        // Mensajes relacionados con el registro de salida
        'check_out' => [
            'no_open' => 'No existe un registro de entrada abierta.',
            'success' => 'Salida registrada correctamente.',
        ],

        // Mensajes relacionados con la actualización del registro
        'update' => [
            'no_changes' => 'No se han realizado cambios en el registro.',
            // Se usa el placeholder :error para inyectar el mensaje específico de la excepción
            'save_error' => 'Error al guardar los cambios: :error',
            'success'    => 'Registro actualizado y auditado correctamente.',
        ],

        // Mensaje para el control de autorización (por ejemplo, en el método show)
        'authorization' => [
            'unauthorized' => 'No está autorizado a ver este registro.',
        ],
    ],
];
