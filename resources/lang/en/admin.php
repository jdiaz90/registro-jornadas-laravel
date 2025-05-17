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
        'edit' => [
            'check_in_label'            => 'Check-in',
            'check_out_label'           => 'Check-out',
            'pause_start_label'         => 'Start Pause',
            'pause_end_label'           => 'End Pause',
            'ordinary_hours_label'      => 'Ordinary Hours',
            'complementary_hours_label' => 'Complementary Hours',
            'overtime_hours_label'      => 'Overtime Hours',
            'pause_minutes_label'       => 'Pause Minutes',
            'modification_reason_label' => 'Modification Reason',
        ],
    ],
    'global_statistics' => [
        'title'       => 'Global Statistics',
        'description' => 'View relevant data and comprehensive system statistics.',
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
    'create_user' => [
        'title'       => 'Create User',
        'description' => 'Complete the form to register a new user in the system',
        'button'      => 'Register User',
    ],

    // Specific texts for users (listing, show, create, and edit view)
    'users' => [
        // Listing view (index)
        'list_title'          => 'Users List',
        'search_placeholder'  => 'Search by name or email',
        'search_button'       => 'Search',
        'table' => [
            'id'    => 'ID',
            'name'  => 'Name',
            'email' => 'Email',
            'role'  => 'Role',
            'actions' => 'Actions',
        ],
        'empty'               => 'No users found.',
        'edit'               => 'Edit',
        'edit_tooltip'       => 'Edit user',

        // Show view
        'show' => [
            'title'           => 'User Profile: :name',
            'back_to_list'    => 'Back to list',
            'info_title'      => 'User Information',
            'labels'          => [
                'name'          => 'Name',
                'email'         => 'Email',
                'role'          => 'Role',
                'contract_type' => 'Contract Type',
            ],
            'work_schedule_title' => 'Work Schedule',
            'no_work_schedule'    => 'This user does not have an assigned work schedule.',
            'work_logs_title'     => 'Work Logs History',
            'edit_button'         => 'Edit',
            'schedule' => [
                'day'             => 'Day',
                'assigned_hours'  => 'Assigned Hours',
                'break_minutes'   => 'Break Minutes',
                'total'           => 'Total',
            ],
        ],

        // Create view
        'create' => [
            'header'     => 'Create User',
            'info_title' => 'User Information',
            'form'       => [
                'name'                  => 'Name',
                'email'                 => 'Email Address',
                'password'              => 'Password',
                'password_confirmation' => 'Confirm Password',
                'role'                  => 'Role',
                'contract_type'         => 'Contract Type',
                'save_changes'          => 'Save Changes',
                'options'               => [
                    'user'      => 'User',
                    'admin'     => 'Administrator',
                    'fulltime'  => 'Full Time',
                    'parttime'  => 'Part Time',
                ],
            ],
            'schedule' => [
                'title' => 'Work Schedule',
                'hours' => 'Assigned Hours',
            ],
        ],

        // Edit view
        'edit' => [
            'header'       => 'Edit User: :name',
            'back_to_list' => 'Back to list',
            'info_title'   => 'User Information',
            'form'         => [
                'name'          => 'Name',
                'email'         => 'Email',
                'role'          => 'Role',
                'contract_type' => 'Contract Type',
                'save_changes'  => 'Save changes',
                'options'       => [
                    'user'      => 'User',
                    'admin'     => 'Administrator',
                    'fulltime'  => 'Full Time',
                    'parttime'  => 'Part Time',
                ],
            ],
            'schedule' => [
                'title' => 'Work Schedule',
                'hours' => 'Assigned Hours',
            ],
        ],
    ],

    // Weekdays
    'weekdays' => [
        'monday'    => 'Monday',
        'tuesday'   => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday'  => 'Thursday',
        'friday'    => 'Friday',
        'saturday'  => 'Saturday',
        'sunday'    => 'Sunday',
    ],
];
