<?php

return [

    // Sección para a vista de login
    'login' => [
        'email'           => 'Correo Electrónico',
        'password'        => 'Contraseña',
        'remember_me'     => 'Recuérdame',
        'forgot_password' => '¿Esqueciches a túa contraseña?',
        'button'          => 'Iniciar sesión',
    ],

    // Sección para a vista de confirmar contraseña
    'confirm_password' => [
        'description' => 'Esta é unha área segura da aplicación. Por favor, confirma a túa contraseña antes de continuar.',
        'password'    => 'Contraseña',
        'button'      => 'Confirmar',
    ],

    // Sección para a vista de recuperar contraseña
    'forgot_password' => [
        'description' => '¿Esqueciches a túa contraseña? Sen problema. Só indícamos o teu enderezo de correo e envíachemos un enlace para reiniciar a contraseña, que che permitirá escoller unha nova.',
        'email_label' => 'Correo Electrónico',
        'button'      => 'Enviar enlace de reinicio de contrasinal',
    ],

    // Sección para a vista de rexistro
    'register' => [
        'name'              => 'Nome',
        'email'             => 'Correo Electrónico',
        'password'          => 'Contraseña',
        'confirm_password'  => 'Confirmar Contraseña',
        'already_registered'=> '¿Xa rexistrado?',
        'button'            => 'Rexistrarse',
    ],

    // Sección para a vista de reset password
    'reset_password' => [
        'email_label'         => 'Correo Electrónico',
        'password'            => 'Contraseña',
        'confirm_password'    => 'Confirmar Contraseña',
        'button'              => 'Restablecer Contraseña',
    ],

    // Sección para a vista de verificación de email
    'verify_email' => [
        'description' => '¡Grazas por rexistrarte! Antes de comezar, poderías verificar o teu correo electrónico facendo clic no enlace que che acabamos de enviar? Se non recibiches o correo, con gusto enviarémosche outro.',
        'sent'        => 'Enviouse un novo enlace de verificación ao enderezo de correo que proporcionaches durante o rexistro.',
        'resend'      => 'Reenviar correo de verificación',
        'log_out'     => 'Pechar sesión',
    ],
];
