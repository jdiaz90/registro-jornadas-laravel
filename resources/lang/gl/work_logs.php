<?php

return [
    // Textos utilizados nas vistas
    'edit' => [
        'header'                    => 'Editar Rexistro #:id',
        'check_in_label'            => 'Entrada',
        'check_out_label'           => 'Saída',
        'current_hash_label'        => 'Hash actual',
        'save_changes'              => 'Gardar cambios',
        'pause_start_label'         => 'Inicio da pausa',
        'pause_end_label'           => 'Fin da pausa',
        'ordinary_hours_label'      => 'Horas ordinarias',
        'complementary_hours_label' => 'Horas complementarias',
        'overtime_hours_label'      => 'Horas extras',
        'pause_minutes_label'       => 'Minutos da pausa',
        'modification_reason_label' => 'Motivo da modificación',
        'char_count'                => ':count/:max caracteres',
        'time_fields_title'         => 'Datos de tempo',
        'hour_fields_title'         => 'Horas calculadas',
    ],

    'index' => [
        'header' => 'Rexistro de Xornada',
        'check_in' => [
            'title'       => 'Rexistrar Entrada',
            'description' => 'Comeza a túa xornada rexistrando a entrada.',
            'button'      => 'Entrada',
        ],
        'check_out' => [
            'title'       => 'Rexistrar Saída',
            'description' => 'Remata a túa xornada rexistrando a saída.',
            'button'      => 'Saída',
        ],
        'pause_start' => [
            'title'       => 'Iniciar Pausa',
            'description' => 'Comeza o teu descanso rexistrando o inicio da pausa.',
            'button'      => 'Iniciar Pausa',
            // Etiquetas para o modal de iniciar pausa
            'modal_title'       => '¿Cando deberías iniciar a pausa?',
            'modal_description' => 'Esta opción está pensada para traballadores con xornada partida ou daqueles que precisan rexistrar un descanso prolongado. Se a túa pausa é breve, como para tomar un café, non é necesario empregar esta opción.',
            'modal_confirm'     => 'Confirmar Pausa',
            'modal_cancel'      => 'Cancelar',
        ],
        'pause_end' => [
            'title'       => 'Finalizar Pausa',
            'description' => 'Finaliza o teu descanso e rexistra a volta ao traballo.',
            'button'      => 'Finalizar Pausa',
            // Etiquetas para o modal de finalizar pausa
            'modal_title'       => '¿Cando deberías finalizar a pausa?',
            'modal_description' => 'Finaliza a pausa só cando realmente volvas á túa actividade laboral.',
            'modal_confirm'     => 'Confirmar Fin de Pausa',
            'modal_cancel'      => 'Cancelar',
        ],
        'history_title' => 'Historial de Rexistros',
    ],

    'show' => [
        'header' => 'Detalle do Rexistro #:id',
    ],

    // Sección para a vista verify.blade.php
    'verify' => [
        'header' => 'Verificar Rexistro',
        
        'success' => [
            'title'    => '¡Rexistro Auténtico!',
            'check_in' => 'Entrada',
            'check_out'=> 'Saída',
            'user'     => 'Utilizador',
        ],

        'failure' => [
            'title'   => 'Código Incorrecto',
            'message' => 'O código hash introducido non coincide co rexistro solicitado.',
        ],
        
        'form' => [
            'id_label'        => 'ID do Rexistro:',
            'id_placeholder'  => 'Introduza o ID do rexistro',
            'hash_label'      => 'Código Hash:',
            'hash_placeholder'=> 'Introduza o código hash',
            'button'          => 'Verificar',
        ],
    ],

    // Mensaxes utilizadas no controlador
    'messages' => [
        'hours_calculation_error' => 'Non se puideron calcular correctamente as horas.',
        'invalid_date_range' => 'A data de inicio non pode ser posterior á data final.',
        'required_date_pair' => 'Debe introducir ambos valores, data de inicio e data de fin, para filtrar o rango.',
        // Mensaxes relacionadas co rexistro de entrada
        'check_in' => [
            'already_open'  => 'Xa rexistraches unha entrada e non completaches a saída.',
            'already_today' => 'Xa rexistraches a túa entrada hoxe.',
            'success'       => 'Entrada rexistrada correctamente.',
        ],

        // Mensaxes relacionadas co rexistro de saída
        'check_out' => [
            'no_open'  => 'Non existe un rexistro de entrada aberta.',
            'success'  => 'Saída rexistrada correctamente.',
        ],

        // Mensaxes relacionadas coa actualización do rexistro
        'update' => [
            'no_changes' => 'Non se fixeron cambios no rexistro.',
            'save_error' => 'Erro ao gardar os cambios: :error',
            'success'    => 'Rexistro actualizado e auditado correctamente.',
        ],

        // Mensaxe para o control de autorización (p.ex., no método show)
        'authorization' => [
            'unauthorized' => 'Non estás autorizado a ver este rexistro.',
        ],
        
        // Mensaxes relacionadas coa xestión das pausas
        'pause' => [
            'start' => [
                'no_active_log'   => 'Non hai un rexistro de xornada aberto para iniciar a pausa.',
                'already_started' => 'A pausa xa se iniciou e non finalizouse.',
                'success'         => 'A pausa iniciouse correctamente.',
            ],
            'end' => [
                'no_active_log' => 'Non hai un rexistro de xornada aberto para finalizar a pausa.',
                'not_started'   => 'Debes iniciar a pausa antes de finalizala.',
                'success'       => 'A pausa finalizouse correctamente.',
            ],
        ],
    ],
];
