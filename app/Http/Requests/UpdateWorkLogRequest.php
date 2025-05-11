<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkLogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'check_in'            => 'required|date|before_or_equal:check_out',
            'check_out'           => 'required|date',
            'pause_start'         => 'nullable|date',
            'pause_end'           => 'nullable|date|after:pause_start',
            // Estos campos se recalcularán, pero se validan para conservar la estructura
            'ordinary_hours'      => 'nullable|numeric',
            'complementary_hours' => 'nullable|numeric',
            'overtime_hours'      => 'nullable|numeric',
            'pause_minutes'       => 'nullable|integer',
            'modification_reason' => 'required|string|max:255',
        ];
    }
}
