<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App; // Necesario para cambiar el idioma inmediatamente

class LocaleController extends Controller
{
    /**
     * Cambia el idioma de la aplicación.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change($locale)
    {
        // Lista de idiomas permitidos
        $allowedLocales = ['es', 'en', 'gl'];
        if (!in_array($locale, $allowedLocales)) {
            abort(400, 'Idioma no permitido');
        }

        // Si el usuario está autenticado, se actualiza la preferencia en la base de datos,
        // de lo contrario, se guarda el idioma en la sesión.
        if (Auth::check()) {
            Auth::user()->update(['locale' => $locale]);
        } else {
            Session::put('locale', $locale);
        }

        // Forzamos el cambio inmediato del idioma en la aplicación
        App::setLocale($locale);

        // Retornamos la redirección con el mensaje de alerta traducido utilizando la clave definida en el archivo de localización (layouts.blade.php)
        return redirect()->back()->with('success', __('layouts.locale_changed', ['locale' => $locale]));
    }
}
