<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLogAudit extends Model
{

    protected $table = 'work_logs_audits';

    protected $fillable = [
        'work_log_id',
        'old_check_in',
        'new_check_in',
        'old_check_out',
        'new_check_out',
        'old_hash',
        'new_hash',
        'updated_by',
    ];
}
