<?php

return [
    // Section for the login view
    'login' => [
        'email'           => 'Email',
        'password'        => 'Password',
        'remember_me'     => 'Remember me',
        'forgot_password' => 'Forgot your password?',
        'button'          => 'Log in',
    ],

    // Section for the confirm password view
    'confirm_password' => [
        'description' => 'This is a secure area of the application. Please confirm your password before continuing.',
        'password'    => 'Password',
        'button'      => 'Confirm',
    ],

    // Section for the forgot password view
    'forgot_password' => [
        'description' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'email_label' => 'Email',
        'button'      => 'Email Password Reset Link',
    ],

    // Section for the register view
    'register' => [
        'name'              => 'Name',
        'email'             => 'Email',
        'password'          => 'Password',
        'confirm_password'  => 'Confirm Password',
        'already_registered'=> 'Already registered?',
        'button'            => 'Register',
    ],

    // Section for the reset password view
    'reset_password' => [
        'email_label'         => 'Email',
        'password'            => 'Password',
        'confirm_password'    => 'Confirm Password',
        'button'              => 'Reset Password',
    ],

    // Section for the verify email view
    'verify_email' => [
        'description' => 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
        'sent'        => 'A new verification link has been sent to the email address you provided during registration.',
        'resend'      => 'Resend Verification Email',
        'log_out'     => 'Log Out',
    ],
];
