<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'check_in', 'check_out', 'hash'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para generar el hash si el registro tiene check_in y check_out
    public function generateHash()
    {
        if ($this->check_in && $this->check_out) {
            // Concatenar los valores usando un separador para evitar ambigüedades.
            $data = $this->user_id . '|' . $this->check_in . '|' . $this->check_out;
            // Usar hash_hmac con SHA-256 y la clave secreta definida en config('app.key')
            return hash_hmac('sha256', $data, config('app.key'));
        }
        return null;
    }

    public function verifyHash()
    {
        if ($this->check_in && $this->check_out && !empty($this->hash)) {
            $data = $this->user_id . '|' . $this->check_in . '|' . $this->check_out;
            return hash_hmac('sha256', $data, config('app.key')) === $this->hash;
        }
        return false;
    }

    // Actualizamos el hash siempre que ambos campos estén definidos
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($log) {
            if ($log->check_in && $log->check_out) {
                $log->hash = $log->generateHash();
            }
        });
    }
}
