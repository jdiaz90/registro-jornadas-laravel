<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Asegúrate de importar la clase correcta.
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Muestra el listado de usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Inicia la consulta a partir del modelo User.
        $query = User::query();
        
        // Si se proporciona un término de búsqueda, se filtra por nombre o correo.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }
    
        // Pagina el resultado mostrando 25 usuarios por página y conserva los parámetros de la URL
        $users = $query->paginate(25)->withQueryString();
    
        // Retorna la vista pasando la variable de usuarios
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Muestra la ficha de usuario junto con el historial de registros (filtrable por mes y año).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User           $user
     * @return \Illuminate\View\View
     */
    public function show(Request $request, User $user)
    {
        // Inicia la consulta a partir de la relación del usuario
        $query = $user->workLogs();

        // Si se especifica un año, filtra por ese año
        if ($request->filled('year')) {
            $query->whereYear('check_in', $request->year);

            // Si además se ha seleccionado un mes, filtra por ese mes
            if ($request->filled('month')) {
                $query->whereMonth('check_in', $request->month);
            }
        }

        // Ordena por fecha descendente y aplica la paginación (por ejemplo, 30 registros por página)
        $logs = $query->orderBy('check_in', 'desc')
                      ->paginate(30)
                      ->withQueryString();

        return view('admin.users.show', compact('user', 'logs'));
    }
}
