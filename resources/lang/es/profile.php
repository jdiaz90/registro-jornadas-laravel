<?php

return [
    'header' => 'Perfil',

    'delete_account' => [
        'title'       => 'Eliminar Cuenta',
        'description' => 'Una vez eliminada su cuenta, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar su cuenta, por favor descargue cualquier dato o información que desee conservar.',
        'modal' => [
            'title'       => '¿Está seguro de que desea eliminar su cuenta?',
            'description' => 'Una vez eliminada su cuenta, todos sus recursos y datos serán eliminados permanentemente. Por favor, ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.',
        ],
        'password' => 'Contraseña',
        'cancel'   => 'Cancelar',
        'button'   => 'Eliminar Cuenta',
    ],

    'update_password' => [
        'title'            => 'Actualizar Contraseña',
        'description'      => 'Asegúrese de que su cuenta esté utilizando una contraseña larga y aleatoria para mantenerse seguro.',
        'current_password' => 'Contraseña Actual',
        'new_password'     => 'Nueva Contraseña',
        'confirm_password' => 'Confirmar Contraseña',
        'button'           => 'Guardar',
        'saved_message'    => 'Guardado.',
    ],

    'update_profile' => [
        'title'              => 'Información del Perfil',
        'description'        => 'Actualice la información de su cuenta y su dirección de correo electrónico.',
        'name'               => 'Nombre',
        'email'              => 'Correo Electrónico',
        'email_unverified'   => 'Su dirección de correo electrónico no está verificada.',
        'resend_verification'=> 'Haga clic aquí para reenviar el correo de verificación.',
        'verification_sent'  => 'Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.',
        'save'               => 'Guardar',
        'saved'              => 'Guardado.',
    ],
];
