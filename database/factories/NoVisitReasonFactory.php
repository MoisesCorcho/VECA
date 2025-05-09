<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NoVisitReason>
 */
class NoVisitReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reasons = [
            'No available client',
            'Change of route',
            'Work office',
        ];

        return [
            'reason' => $this->faker->randomElement($reasons),
        ];
    }
}
