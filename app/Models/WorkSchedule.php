<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSchedule extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'monday_hours', 'monday_break_minutes',
        'tuesday_hours', 'tuesday_break_minutes',
        'wednesday_hours', 'wednesday_break_minutes',
        'thursday_hours', 'thursday_break_minutes',
        'friday_hours', 'friday_break_minutes',
        'saturday_hours', 'saturday_break_minutes',
        'sunday_hours', 'sunday_break_minutes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
