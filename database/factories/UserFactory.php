<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WorkSchedule;
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
        // Forzamos la creación del objeto Faker con el locale 'es_ES'
        $this->faker = \Faker\Factory::create('es_ES');
        return [
            'name'              => $this->faker->name(), 
            'email'             => $this->faker->unique()->safeEmail(),
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
    
    /**
     * Configurar la fábrica para que, después de crear un usuario,
     * se genere automáticamente su WorkSchedule asociado, si no existe.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if (!$user->workSchedule) {
                WorkSchedule::factory()->create(['user_id' => $user->id]);
            }
        });
    }
}
