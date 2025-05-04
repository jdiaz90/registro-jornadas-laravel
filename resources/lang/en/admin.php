<?php

return [

    // General text for the administration panel
    'admin_panel'        => 'Admin Panel',
    'welcome'            => 'Welcome, Administrator :name!',
    'description'        => 'Access the panel to manage users, review logs, and obtain system statistics.',

    // Dashboard cards/data
    'user_management' => [
        'title'       => 'User Management',
        'description' => 'Manage users, review profiles, and update information.',
        'button'      => 'View Users',
    ],
    'work_logs' => [
        'title'       => 'Work Logs',
        'description' => 'Review and filter user work logs.',
        'button'      => 'View Work Logs',
    ],
    'global_statistics' => [
        'title'       => 'Global Statistics',
        'description' => 'View relevant data and overall system statistics.',
        'button'      => 'View Statistics',
    ],
    'calendar' => [
        'title'       => 'Calendar',
        'description' => 'Check your calendar of activities and logs.',
        'button'      => 'View Calendar',
    ],
    'reports' => [
        'title'       => 'Export Reports',
        'description' => 'Download Excel reports for analysis.',
        'button'      => 'Download Excel',
    ],
    'settings' => [
        'title'       => 'Settings',
        'description' => 'Access advanced system settings and manage permissions.',
        'button'      => 'Configure',
    ],

    // Specific texts for users (listing and show view)
    'users' => [
        // Listing view (index)
        'list_title'          => 'Users List',
        'search_placeholder'  => 'Search by name or email',
        'search_button'       => 'Search',
        'table' => [
            'id'      => 'ID',
            'name'    => 'Name',
            'email'   => 'Email',
            'role'    => 'Role',
        ],
        'empty'               => 'No users were found.',

        // Show view
        'show' => [
            'title'           => 'User Profile: :name',
            'back_to_list'    => 'Back to list',
            'info_title'      => 'User Information',
            'labels' => [
                'name'  => 'Name',
                'email' => 'Email',
                'role'  => 'Role',
            ],
            'work_logs_title' => 'Work Logs History',
        ],
    ],
];
