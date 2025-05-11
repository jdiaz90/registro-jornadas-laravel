<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Muestra el listado de usuarios.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
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

        // Pagina el resultado mostrando 25 usuarios por página y conserva los parámetros de la URL.
        $users = $query->paginate(25)->withQueryString();

        // Retorna la vista pasando la variable de usuarios.
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra la ficha de usuario junto con el historial de registros (filtrable por mes y año).
     *
     * @param Request $request
     * @param User $user
     * @return View
     */
    public function show(Request $request, User $user): View
    {
        // Inicia la consulta a partir de la relación del usuario.
        $query = $user->workLogs();

        // Si se especifica un año, filtra por ese año.
        if ($request->filled('year')) {
            $query->whereYear('check_in', $request->year);

            // Si además se ha seleccionado un mes, filtra por ese mes.
            if ($request->filled('month')) {
                $query->whereMonth('check_in', $request->month);
            }
        }

        // Ordena por fecha descendente y aplica la paginación (por ejemplo, 30 registros por página).
        $logs = $query->orderBy('check_in', 'desc')
                      ->paginate(30)
                      ->withQueryString();

        return view('admin.users.show', compact('user', 'logs'));
    }

    /**
     * Muestra el formulario de creación de un usuario.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos, incluyendo el horario de trabajo.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos del usuario y del work_schedule.
        $validated = $request->validate([
            'name'                              => 'required|string|max:255',
            'email'                             => 'required|string|email|max:255|unique:users',
            'role'                              => 'required|string|in:admin,user',
            'contract_type'                     => 'required|string|in:fulltime,parttime',
            'work_schedule.monday_hours'        => 'required|integer|min:0|max:24',
            'work_schedule.tuesday_hours'       => 'required|integer|min:0|max:24',
            'work_schedule.wednesday_hours'     => 'required|integer|min:0|max:24',
            'work_schedule.thursday_hours'      => 'required|integer|min:0|max:24',
            'work_schedule.friday_hours'        => 'required|integer|min:0|max:24',
            'work_schedule.saturday_hours'      => 'required|integer|min:0|max:24',
            'work_schedule.sunday_hours'        => 'required|integer|min:0|max:24',
        ]);

        try {
            // Creamos el usuario.
            $user = new User();
            $user->fill($validated);
            $user->save();

            // Procesamos los datos del work_schedule.
            $workScheduleData = $request->input('work_schedule');
            if ($workScheduleData) {
                $user->workSchedule()->create($workScheduleData);
            }

            return redirect()
                ->route('admin.users.show', $user->id)
                ->with('status', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'No se pudo crear el usuario.');
        }
    }

    /**
     * Muestra el formulario de edición de un usuario.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza el usuario en la base de datos, incluyendo el horario de trabajo.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Validación de los datos del usuario y del work_schedule.
        $validated = $request->validate([
            'name'                              => 'required|string|max:255',
            'email'                             => 'required|string|email|max:255|unique:users,email,' . $id,
            'role'                              => 'required|string|in:admin,user',
            'contract_type'                     => 'required|string|in:fulltime,parttime',
            'work_schedule.monday_hours'        => 'required|integer|min:0|max:24',
            'work_schedule.tuesday_hours'       => 'required|integer|min:0|max:24',
            'work_schedule.wednesday_hours'     => 'required|integer|min:0|max:24',
            'work_schedule.thursday_hours'      => 'required|integer|min:0|max:24',
            'work_schedule.friday_hours'        => 'required|integer|min:0|max:24',
            'work_schedule.saturday_hours'      => 'required|integer|min:0|max:24',
            'work_schedule.sunday_hours'        => 'required|integer|min:0|max:24',
        ]);

        try {
            // Actualizamos los datos básicos del usuario.
            $user->fill($validated);

            // Procesamos los datos del work_schedule.
            $workScheduleData = $request->input('work_schedule');
            if ($workScheduleData) {
                // Si el usuario ya tiene un workSchedule registrado, lo actualizamos;
                // de lo contrario, creamos uno nuevo.
                if ($user->workSchedule) {
                    $user->workSchedule()->update($workScheduleData);
                } else {
                    $user->workSchedule()->create($workScheduleData);
                }
            }

            if ($user->save()) {
                return redirect()
                    ->route('admin.users.show', $user->id)
                    ->with('status', 'Usuario actualizado correctamente.');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'No se pudieron guardar los cambios.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'No se pudieron guardar los cambios.');
        }
    }

    /**
     * (Opcional) Elimina un usuario de la base de datos.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            return redirect()
                ->route('admin.users.index')
                ->with('status', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'No se pudo eliminar el usuario.');
        }
    }
}
