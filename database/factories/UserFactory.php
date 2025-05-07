<?php

namespace Database\Factories;

use App\Enums\DniType;
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
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => null,
            'cellphone' => $this->faker->numerify('##########'),
            'dni_type' => $this->faker->randomElement(DniType::cases())->value,
            'dni' => $this->faker->numerify('########'),
            'active' => true,
            'visits_per_day' => $this->faker->numberBetween(1, 10),
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
     * Indicate that the user should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Indicate that the user should have a specific number of visits per day.
     */
    public function withVisitsPerDay(int $visits): static
    {
        return $this->state(fn(array $attributes) => [
            'visits_per_day' => $visits,
        ]);
    }

    /**
     * Indicate that the user should have a specific type of identification.
     */
    public function withIdentification(string $type, string $number): static
    {
        return $this->state(fn(array $attributes) => [
            'dni_type' => $type,
            'dni' => $number,
        ]);
    }
}
