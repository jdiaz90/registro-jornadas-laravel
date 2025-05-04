<?php

return [
    'header' => 'Profile',

    'delete_account' => [
        'title'       => 'Delete Account',
        'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'modal' => [
            'title'       => 'Are you sure you want to delete your account?',
            'description' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
        ],
        'password' => 'Password',
        'cancel'   => 'Cancel',
        'button'   => 'Delete Account',
    ],

    'update_password' => [
        'title'            => 'Update Password',
        'description'      => 'Ensure your account is using a long, random password to stay secure.',
        'current_password' => 'Current Password',
        'new_password'     => 'New Password',
        'confirm_password' => 'Confirm Password',
        'button'           => 'Save',
        'saved_message'    => 'Saved.',
    ],

    'update_profile' => [
        'title'              => 'Profile Information',
        'description'        => "Update your account's profile information and email address.",
        'name'               => 'Name',
        'email'              => 'Email',
        'email_unverified'   => 'Your email address is unverified.',
        'resend_verification'=> 'Click here to re-send the verification email.',
        'verification_sent'  => 'A new verification link has been sent to your email address.',
        'save'               => 'Save',
        'saved'              => 'Saved.',
    ],
];
