<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el dashboard exclusivo para administradores.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Puedes pasar datos o estadísticas aquí si es necesario.
        return view('admin.dashboard');
    }
}
