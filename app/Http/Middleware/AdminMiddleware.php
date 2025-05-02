<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;

class AdminMiddleware
{
    /**
     * Manejar la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica que el usuario esté autenticado y que su 'role' sea 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
