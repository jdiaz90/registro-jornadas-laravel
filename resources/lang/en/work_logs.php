<?php

return [
    'edit' => [
        'header'             => 'Edit Record #:id',
        'check_in_label'     => 'Check-in',
        'check_out_label'    => 'Check-out',
        'current_hash_label' => 'Current Hash',
        'save_changes'       => 'Save Changes',
    ],

    'index' => [
        'header' => 'Work Log',
        'check_in' => [
            'title'       => 'Log Check-in',
            'description' => 'Start your workday by logging your check-in.',
            'button'      => 'Check-in',
        ],
        'check_out' => [
            'title'       => 'Log Check-out',
            'description' => 'End your workday by logging your check-out.',
            'button'      => 'Check-out',
        ],
        'history_title' => 'Work Log History',
    ],

    'show' => [
        'header' => 'Record Detail #:id',
    ],

    // Section for verify.blade.php
    'verify' => [
        'header' => 'Verify Record',
        
        'success' => [
            'title'    => 'Authentic Record!',
            'check_in' => 'Check In',
            'check_out'=> 'Check Out',
            'user'     => 'User',
        ],

        'failure' => [
            'title'   => 'Incorrect Code',
            'message' => 'The hash code you entered does not match the requested record.',
        ],
        
        'form' => [
            'id_label'        => 'Record ID:',
            'id_placeholder'  => 'Enter the record ID',
            'hash_label'      => 'Hash Code:',
            'hash_placeholder'=> 'Enter the hash code',
            'button'          => 'Verify'
        ],
    ],

    // Other groups or keys...
];
