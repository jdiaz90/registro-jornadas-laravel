<?php

return [
    'header' => 'Perfil',

    'delete_account' => [
        'title'       => 'Eliminar Conta',
        'description' => 'Unha vez eliminada a súa conta, todos os seus recursos e datos eliminaranse permanentemente. Antes de eliminar a súa conta, por favor descargue calquera dato ou información que desexe conservar.',
        'modal' => [
            'title'       => 'Está seguro de que desexa eliminar a súa conta?',
            'description' => 'Unha vez eliminada a súa conta, todos os seus recursos e datos eliminaranse permanentemente. Por favor, introduza o seu contrasinal para confirmar que desexa eliminar permanentemente a súa conta.',
        ],
        'password' => 'Contrasinal',
        'cancel'   => 'Cancelar',
        'button'   => 'Eliminar Conta',
    ],

    'update_password' => [
        'title'            => 'Actualizar Contrasinal',
        'description'      => 'Asegúrese de que a súa conta empregue un contrasinal longo e aleatorio para mantenerse seguro.',
        'current_password' => 'Contrasinal Actual',
        'new_password'     => 'Nova Contrasinal',
        'confirm_password' => 'Confirmar Contrasinal',
        'button'           => 'Gardar',
        'saved_message'    => 'Gardado.',
    ],

    'update_profile' => [
        'title'              => 'Información do Perfil',
        'description'        => 'Actualice a información da súa conta e o seu enderezo de correo electrónico.',
        'name'               => 'Nome',
        'email'              => 'Correo Electrónico',
        'email_unverified'   => 'A súa dirección de correo electrónico non está verificada.',
        'resend_verification'=> 'Prema aquí para reenviar o correo de verificación.',
        'verification_sent'  => 'Enviouse un novo enlace de verificación á súa dirección de correo electrónico.',
        'save'               => 'Gardar',
        'saved'              => 'Gardado.',
    ],
];
