<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'nit' => $this->faker->numerify('###-###-###'),
            'cellphone' => $this->faker->numerify('##########'),
            'phone' => $this->faker->numerify('########'),
            'email' => $this->faker->unique()->companyEmail(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Configure the organization with an existing user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Configure the organization with a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name,
        ]);
    }

    /**
     * Configure the organization with a specific description.
     */
    public function withDescription(string $description): static
    {
        return $this->state(fn(array $attributes) => [
            'description' => $description,
        ]);
    }

    /**
     * Configure the organization with a specific NIT.
     */
    public function withNit(string $nit): static
    {
        return $this->state(fn(array $attributes) => [
            'nit' => $nit,
        ]);
    }

    /**
     * Configure the organization with specific contact information.
     */
    public function withContactInfo(string $email, string $cellphone, ?string $phone = null): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => $email,
            'cellphone' => $cellphone,
            'phone' => $phone ?? $this->faker->numerify('########'),
        ]);
    }
}
