<?php

namespace Database\Factories;

use App\Enums\VisitStatusEnum;
use App\Models\User;
use App\Models\Organization;
use App\Models\NoVisitReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visit_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'rescheduled_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'non_visit_description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(VisitStatusEnum::cases())->value,
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'non_visit_reason_id' => NoVisitReason::factory(),
        ];
    }

    public function visited(): static
    {
        return $this->state(fn(array $attributes) => [
            'visit_date' => $this->faker->dateTimeBetween('-10 day', '-1 day'),
            'rescheduled_date' => null,
            'status' => VisitStatusEnum::VISITED->value,
            'non_visit_description' => null,
            'non_visit_reason_id' => null,
        ]);
    }

    public function notVisited(): static
    {
        return $this->state(fn(array $attributes) => [
            'visit_date' => $this->faker->dateTimeBetween('-10 day', '-1 day'),
            'rescheduled_date' => null,
            'status' => VisitStatusEnum::NOT_VISITED->value,
            'non_visit_reason_id' => NoVisitReason::factory(),
        ]);
    }

    public function canceled(): static
    {
        return $this->state(fn(array $attributes) => [
            'visit_date' => $this->faker->dateTimeBetween('-2 day', '+10 day'),
            'rescheduled_date' => null,
            'status' => VisitStatusEnum::CANCELED->value,
            'non_visit_description' => $this->faker->sentence(),
            'non_visit_reason_id' => NoVisitReason::factory(),
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn(array $attributes) => [
            'visit_date' => $this->faker->dateTimeBetween('+2 day', '+10 day'),
            'rescheduled_date' => null,
            'status' => VisitStatusEnum::SCHEDULED->value,
            'non_visit_description' => null,
            'non_visit_reason_id' => null,
        ]);
    }

    public function rescheduled(): static
    {
        return $this->state(fn(array $attributes) => [
            'visit_date' => $this->faker->dateTimeBetween('+2 day', '+10 day'),
            'rescheduled_date' => $this->faker->dateTimeBetween('+2 day', '+10 day'),
            'status' => VisitStatusEnum::RESCHEDULED->value,
            'non_visit_description' => null,
            'non_visit_reason_id' => null,
        ]);
    }
}
