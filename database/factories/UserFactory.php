<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Forzamos la creación del objeto Faker con el locale 'en_US'
        $this->faker = \Faker\Factory::create('es_ES');
        // Opcional: agregar el provider de Person, aunque normalmente no es necesario
        // $this->faker->addProvider(new \Faker\Provider\en_US\Person($this->faker));
    
        return [
            'name'              => $this->faker->name(), // Llamada al método name()
            'email'             => $this->faker->unique()->safeEmail(), // Con paréntesis
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            // Campos adicionales para nuestros usuarios
            'role'              => $this->faker->randomElement(['user', 'admin']),
            'locale'            => 'es',
            'contract_type'     => $this->faker->randomElement(['fulltime', 'parttime']),
        ];
    }
    

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
