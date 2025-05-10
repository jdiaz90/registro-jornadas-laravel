<?php

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature');

it('cambia el idioma para un usuario autenticado', function () {
    // Creamos un usuario con un idioma inicial (por ejemplo, 'es').
    $user = User::factory()->create(['locale' => 'es']);
    $this->actingAs($user);

    // Definimos una URL de referencia para simular el "back" en la redirección.
    $referer = 'http://example.com/previous';

    // Llamamos a la ruta con un locale permitido, por ejemplo, 'en'.
    $response = $this->withHeaders(['referer' => $referer])
                     ->get(route('locale.change', ['locale' => 'en']));

    // Se espera que redirija a la URL de referencia.
    $response->assertRedirect($referer);

    // Recargamos el usuario para obtener el valor actualizado.
    $user->refresh();
    expect($user->locale)->toBe('en');

    // Verificamos que la aplicación tenga el idioma configurado inmediatamente.
    expect(App::getLocale())->toBe('en');

    // Comprobamos que la sesión tenga un mensaje flash de éxito.
    $response->assertSessionHas('success');
});

it('guarda el idioma en la sesión para un usuario invitado', function () {
    // No autenticamos al usuario, actuando como invitado.
    $referer = 'http://example.com/previous';

    // Llamamos a la ruta con un locale permitido, por ejemplo, 'gl'.
    $response = $this->withHeaders(['referer' => $referer])
                     ->get(route('locale.change', ['locale' => 'gl']));

    // Se espera que redirija a la URL de referencia.
    $response->assertRedirect($referer);

    // Verificamos que el idioma se ha guardado en la sesión.
    expect(Session::get('locale'))->toBe('gl');

    // Comprobamos que se haya configurado el mensaje flash de éxito.
    $response->assertSessionHas('success');
});

it('arroja error 400 si se proporciona un idioma no permitido', function () {
    // Puede ser tanto para un usuario autenticado o invitado.
    $user = User::factory()->create();
    $this->actingAs($user);

    // Usamos un idioma no permitido, por ejemplo 'fr'.
    $response = $this->get(route('locale.change', ['locale' => 'fr']));

    // Se espera un status 400.
    $response->assertStatus(400);
});
