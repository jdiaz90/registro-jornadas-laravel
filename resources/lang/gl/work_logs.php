<?php

return [
    // Textos utilizados en as vistas
    'edit' => [
        'header'             => 'Editar Rexistro #:id',
        'check_in_label'     => 'Entrada',
        'check_out_label'    => 'Saída',
        'current_hash_label' => 'Hash actual',
        'save_changes'       => 'Gardar cambios',
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
        // Mensaxes relacionadas co rexistro de entrada
        'check_in' => [
            'already_open' => 'Xa rexistraches unha entrada e non completaches a saída.',
            'success'      => 'Entrada rexistrada correctamente.',
        ],

        // Mensaxes relacionadas co rexistro de saída
        'check_out' => [
            'no_open' => 'Non existe un rexistro de entrada aberta.',
            'success' => 'Saída rexistrada correctamente.',
        ],

        // Mensaxes relacionadas coa actualización do rexistro
        'update' => [
            'no_changes' => 'Non se fixeron cambios no rexistro.',
            // Usa o placeholder :error para inxectar a mensaxe específica da excepción
            'save_error' => 'Erro ao gardar os cambios: :error',
            'success'    => 'Rexistro actualizado e auditado correctamente.',
        ],

        // Mensaxe para o control de autorización (por exemplo, no método show)
        'authorization' => [
            'unauthorized' => 'Non está autorizado a ver este rexistro.',
        ],
    ],
];
