<?php

return [
    // Texts for the Work Logs views
    'edit' => [
        'header'                    => 'Edit Record #:id',
        'check_in_label'            => 'Check-in',
        'check_out_label'           => 'Check-out',
        'current_hash_label'        => 'Current Hash',
        'save_changes'              => 'Save Changes',
        'pause_start_label'         => 'Start Pause',
        'pause_end_label'           => 'End Pause',
        'ordinary_hours_label'      => 'Ordinary Hours',
        'complementary_hours_label' => 'Complementary Hours',
        'overtime_hours_label'      => 'Overtime Hours',
        'pause_minutes_label'       => 'Pause Minutes',
        'modification_reason_label' => 'Modification Reason',
        'char_count'                => ':count/:max characters',
        'time_fields_title'         => 'Time Fields',
        'hour_fields_title'         => 'Calculated Hours',
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
        'pause_start' => [
            'title'             => 'Start Pause',
            'description'       => 'Begin your break time.',
            'button'            => 'Start Pause',
            // Modal labels for starting a break
            'modal_title'       => 'When Should You Start a Break?',
            'modal_description' => 'This option is intended for split-shift workers or those who need to register a long break. If your break is brief, such as for a coffee, you do not need to use this option.',
            'modal_confirm'     => 'Confirm Break',
            'modal_cancel'      => 'Cancel',
        ],
        'pause_end' => [
            'title'             => 'End Pause',
            'description'       => 'Finish your break and resume work.',
            'button'            => 'End Pause',
            // Modal labels for ending a break
            'modal_title'       => 'When Should You End a Break?',
            'modal_description' => 'End your break only when you are truly resuming work.',
            'modal_confirm'     => 'Confirm End of Break',
            'modal_cancel'      => 'Cancel',
        ],
        'history_title' => 'Work Log History',
    ],

    'show' => [
        'header' => 'Record Detail #:id',
    ],

    // Section for the verify.blade.php view
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
            'button'          => 'Verify',
        ],
    ],

    // Messages used, for example, in the controller
    'messages' => [
        'hours_calculation_error' => 'Hours could not be calculated correctly.',
        'invalid_date_range' => 'The start date cannot be later than the end date.',
        'required_date_pair' => 'You must enter both the start and end date to filter the range.',
        // Messages related to check-in
        'check_in' => [
            'already_open'  => 'You have already registered a check-in and have not completed check-out.',
            'already_today' => 'You have already registered your check-in for today.',
            'success'       => 'Check-in registered successfully.',
        ],

        // Messages related to check-out
        'check_out' => [
            'no_open' => 'There is no open check-in record.',
            'success' => 'Check-out registered successfully.',
        ],

        // Messages related to updating a record
        'update' => [
            'no_changes' => 'No changes have been made to the record.',
            'save_error' => 'Error saving changes: :error',
            'success'    => 'Record updated and audited successfully.',
        ],

        // Authorization message (for example, in the show method)
        'authorization' => [
            'unauthorized' => 'You are not authorized to view this record.',
        ],
        
        // Messages related to break management
        'pause' => [
            'start' => [
                'no_active_log'   => 'There is no active work log to start a break.',
                'already_started' => 'The break has already been started and is not yet finished.',
                'success'         => 'Break started successfully.',
            ],
            'end' => [
                'no_active_log' => 'There is no active work log to end a break.',
                'not_started'   => 'You must start a break before ending it.',
                'success'       => 'Break ended successfully.',
            ],
        ],
    ],
];
