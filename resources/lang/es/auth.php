<?php

return [
    // Sección para la vista de login
    'login' => [
        'email'           => 'Correo Electrónico',
        'password'        => 'Contraseña',
        'remember_me'     => 'Recuérdame',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'button'          => 'Iniciar sesión',
    ],

    // Sección para la vista de confirmar contraseña
    'confirm_password' => [
        'description' => 'Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.',
        'password'    => 'Contraseña',
        'button'      => 'Confirmar',
    ],

    // Sección para la vista de recuperar contraseña
    'forgot_password' => [
        'description' => '¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace de reinicio de contraseña para que puedas elegir una nueva.',
        'email_label' => 'Correo Electrónico',
        'button'      => 'Enviar enlace de reinicio de contraseña',
    ],

    // Sección para la vista de registro
    'register' => [
        'name'              => 'Nombre',
        'email'             => 'Correo Electrónico',
        'password'          => 'Contraseña',
        'confirm_password'  => 'Confirmar Contraseña',
        'already_registered'=> '¿Ya registrado?',
        'button'            => 'Registrarse',
    ],

    // Sección para la vista de reset password
    'reset_password' => [
        'email_label'         => 'Correo Electrónico',
        'password'            => 'Contraseña',
        'confirm_password'    => 'Confirmar Contraseña',
        'button'              => 'Restablecer Contraseña',
    ],

    // Sección para la vista de verificación de email
    'verify_email' => [
        'description' => '¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.',
        'sent'        => 'Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.',
        'resend'      => 'Reenviar correo de verificación',
        'log_out'     => 'Cerrar sesión',
    ],
];
