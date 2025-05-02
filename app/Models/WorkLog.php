<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    protected $fillable = ['user_id', 'check_in', 'check_out', 'hash'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para generar el hash si el registro está completo
    public function generateHash()
    {
        if ($this->check_in && $this->check_out) {
            $data = $this->user_id . $this->check_in . $this->check_out;
            return hash_hmac('sha256', $data, config('app.key'));
        }
        return null;
    }

    // Asignar el hash justo antes de guardar, si es necesario
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($log) {
            // Únicamente genera el hash si ambos campos están definidos y aún no está generado.
            if ($log->check_in && $log->check_out && empty($log->hash)) {
                $log->hash = $log->generateHash();
            }
        });
    }
}
