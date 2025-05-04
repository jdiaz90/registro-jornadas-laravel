<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $defaultLocale = config('app.locale'); // Valor por defecto, definido en config/app.php
        $locale = $defaultLocale;
        
        if (Auth::check()) {
            // Si el usuario está autenticado, usar la preferencia almacenada en la DB.
            $locale = Auth::user()->locale ?? $defaultLocale;
        } else {
            // Para usuarios no autenticados, utilizar la preferencia de la sesión
            $locale = session('locale', $defaultLocale);
        }
        
        App::setLocale($locale);
        return $next($request);
    }
}
