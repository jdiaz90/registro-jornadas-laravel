<?php

return [
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
            'user'     => 'Utilizador'
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
            'button'          => 'Verificar'
        ],
    ],

    // Outras seccións que xa teñas...
];
