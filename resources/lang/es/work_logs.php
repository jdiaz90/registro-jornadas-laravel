<?php

return [
    // Sección de vistas
    'edit' => [
        'header'                    => 'Editar Registro #:id',
        'check_in_label'            => 'Entrada',
        'check_out_label'           => 'Salida',
        'current_hash_label'        => 'Hash actual',
        'save_changes'              => 'Guardar cambios',
        'pause_start_label'         => 'Inicio de pausa',
        'pause_end_label'           => 'Fin de pausa',
        'ordinary_hours_label'      => 'Horas ordinarias',
        'complementary_hours_label' => 'Horas complementarias',
        'overtime_hours_label'      => 'Horas extras',
        'pause_minutes_label'       => 'Minutos de pausa',
        'modification_reason_label' => 'Motivo de la modificación',
        'char_count'                => ':count/:max caracteres',
        'time_fields_title'         => 'Datos de tiempo',
        'hour_fields_title'         => 'Horas calculadas',
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
        'pause_start' => [
            'title'             => 'Iniciar Pausa',
            'description'       => 'Inicia la pausa de descanso.',
            'button'            => 'Iniciar Pausa',
            // Etiquetas para el modal de iniciar pausa
            'modal_title'       => '¿Cuándo deberías iniciar una pausa?',
            'modal_description' => 'Esta opción está pensada para trabajadores con jornada partida o aquellos que necesiten registrar un descanso prolongado. Si tu pausa es breve, como para tomar un café, no es necesario utilizar este botón.',
            'modal_confirm'     => 'Confirmar Pausa',
            'modal_cancel'      => 'Cancelar',
        ],
        'pause_end' => [
            'title'             => 'Finalizar Pausa',
            'description'       => 'Finaliza la pausa y registra el reinicio de la jornada.',
            'button'            => 'Finalizar Pausa',
            // Etiquetas para el modal de finalizar pausa
            'modal_title'       => '¿Cuándo deberías finalizar una pausa?',
            'modal_description' => 'Solo finaliza la pausa cuando realmente vuelvas a tu actividad laboral.',
            'modal_confirm'     => 'Confirmar Fin de Pausa',
            'modal_cancel'      => 'Cancelar',
        ],
        'history_title' => 'Historial de Registros',
    ],

    'show' => [
        'header' => 'Detalle del Registro #:id',
    ],

    // Sección para la vista de verificación (verify.blade.php)
    'verify' => [
        'header' => 'Verificar Registro',
        
        'success' => [
            'title'    => '¡Registro Auténtico!',
            'check_in' => 'Entrada',
            'check_out'=> 'Salida',
            'user'     => 'Usuario',
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
            'button'          => 'Verificar',
        ],
    ],

    // Otros mensajes usados en el controlador
    'messages' => [
        'hours_calculation_error' => 'No se pudieron calcular las horas correctamente.',
        // Mensajes relacionados con el registro de entrada
        'check_in' => [
            'already_open'  => 'Ya has registrado una entrada y no has completado la salida.',
            'already_today' => 'Ya has registrado tu entrada para hoy.',
            'success'       => 'Entrada registrada correctamente.',
        ],

        // Mensajes relacionados con el registro de salida
        'check_out' => [
            'no_open'  => 'No existe un registro de entrada abierta.',
            'success'  => 'Salida registrada correctamente.',
        ],

        // Mensajes relacionados con la actualización del registro
        'update' => [
            'no_changes' => 'No se han realizado cambios en el registro.',
            'save_error' => 'Error al guardar los cambios: :error',
            'success'    => 'Registro actualizado y auditado correctamente.',
        ],

        // Mensajes para control de autorización
        'authorization' => [
            'unauthorized' => 'No está autorizado a ver este registro.',
        ],
        
        // Mensajes para la gestión de pausas
        'pause' => [
            'start' => [
                'no_active_log'   => 'No hay un registro de jornada abierto para iniciar la pausa.',
                'already_started' => 'La pausa ya ha sido iniciada y no ha finalizado.',
                'success'         => 'La pausa se ha iniciado correctamente.',
            ],
            'end' => [
                'no_active_log' => 'No hay un registro de jornada abierto para finalizar la pausa.',
                'not_started'   => 'Debes iniciar la pausa antes de finalizarla.',
                'success'       => 'La pausa se ha finalizado correctamente.',
            ],
        ],
    ],
];
