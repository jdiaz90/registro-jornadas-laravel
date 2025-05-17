<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkLogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'check_in'            => 'required|date|before_or_equal:check_out',
            'check_out'           => 'required|date|after_or_equal:check_in',
            // Si se ingresa pause_start, se debe asegurar que sea mayor o igual a check_in y menor o igual a check_out
            'pause_start'         => 'nullable|date|after_or_equal:check_in|before_or_equal:check_out',
            // Si se ingresa pause_end, se debe asegurar que sea posterior a pause_start y no mayor a check_out
            'pause_end'           => 'nullable|date|after:pause_start|before_or_equal:check_out',
            // Estos campos se recalcularán, pero se validan para conservar la estructura
            'ordinary_hours'      => 'nullable|numeric',
            'complementary_hours' => 'nullable|numeric',
            'overtime_hours'      => 'nullable|numeric',
            'pause_minutes'       => 'nullable|integer',
            'modification_reason' => 'required|string|max:255',
        ];
    }
}
