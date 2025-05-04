<?php

return [
    // Main header text
    'header' => 'Dashboard',

    // Welcome section
    'welcome' => [
        'greeting'    => 'Welcome, :name!',
        'description' => 'Explore your activity and manage your records from here.',
    ],

    // Dashboard cards
    'cards' => [
        'work_logs' => [
            'title'       => 'My Work Logs',
            'description' => 'Review and manage your check-in and check-out records.',
            'button'      => 'View Work Logs',
            'count_label' => 'Logs',
        ],
        'profile' => [
            'title'       => 'My Profile',
            'description' => 'Update your personal details and configure your account.',
            'button'      => 'Edit Profile',
        ],
        'statistics' => [
            'title'        => 'Statistics',
            'description'  => 'Here you could display relevant data, such as total registered hours or activity indicators.',
            'data_counter' => ':count Registered Hours',
        ],
        'calendar' => [
            'title'       => 'Calendar',
            'description' => 'View your annual calendar and check your records day by day.',
            'button'      => 'View Calendar',
        ],
        'export_report' => [
            'title'       => 'Export Report',
            'description' => 'Download your check-in and check-out records in Excel format.',
            'button'      => 'Download Excel',
        ],
        'verify_record' => [
            'title'       => 'Verify Record',
            'description' => 'Verify the integrity of your records by entering the hash code.',
            'button'      => 'Verify Record',
        ],
    ],
];
