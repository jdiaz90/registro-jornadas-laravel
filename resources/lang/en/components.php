<?php

return [
    'alert' => [
        'close' => 'Close',
    ],

    'work_log_detail' => [
        'current_info_title' => 'Current Information',
        'label' => [
            'user'                => 'User',
            'hash'                => 'Hash',
            'check_in'            => 'Check-in',
            'check_out'           => 'Check-out',
            'pause_start'         => 'Start Pause',
            'pause_end'           => 'End Pause',
            'ordinary_hours'      => 'Ordinary Hours',
            'complementary_hours' => 'Complementary Hours',
            'overtime_hours'      => 'Overtime Hours',
            'pause_minutes'       => 'Pause Minutes',
            'created_at'          => 'Created',
            'updated_at'          => 'Updated',
            'modification_reason' => 'Modification Reason',
        ],
        'audit_history_title' => 'Audit History',
        'audit_empty'         => 'No changes were found for this record.',
        'table' => [
            'date'            => 'Date',
            'modified_fields' => 'Modified Field(s)',
            'old_value'       => 'Old Value',
            'new_value'       => 'New Value',
            'updated_by'      => 'Updated By',
        ],
        'edit_button'  => 'Edit Record',
        'print_button' => 'Print Record',
    ],

    'work_logs_table' => [
        'title' => 'Work Log History',
        'filter' => [
            'label_start_date' => 'Start Date',
            'label_end_date'   => 'End Date',
            'label_user'       => 'User',
            'option_all'       => 'All',
            'button_filter'    => 'Filter',
        ],
        'table' => [
            'id'                  => 'ID',
            'user'                => 'User',
            'check_in'            => 'Check-in',
            'check_out'           => 'Check-out',
            'pause_start'         => 'Start Pause',
            'pause_end'           => 'End Pause',
            'ordinary_hours'      => 'Ordinary Hours',
            'complementary_hours' => 'Complementary Hours',
            'overtime_hours'      => 'Overtime Hours',
            'pause_minutes'       => 'Pause Minutes',
            'hash'                => 'Hash',
            'no_records'          => 'No records found.',
        ],
        'ongoing' => 'Ongoing',
        'pending' => 'Pending',
    ],

    'work_logs' => [
        'messages' => [
            'invalid_date_range' => 'The start date cannot be later than the end date.',
            'required_date_pair' => 'You must enter both the start and end date to filter the range.',
            'authorization'      => 'You do not have permission to view these records.',
        ],
    ],

    // Month labels
    'months' => [
        '1'  => 'January',
        '2'  => 'February',
        '3'  => 'March',
        '4'  => 'April',
        '5'  => 'May',
        '6'  => 'June',
        '7'  => 'July',
        '8'  => 'August',
        '9'  => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ],
];
