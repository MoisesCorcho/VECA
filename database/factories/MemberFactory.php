<?php

namespace Database\Factories;

use App\Enums\DniType;
use App\Models\Organization;
use App\Models\MemberPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'dni_type' => $this->faker->randomElement(DniType::cases())->value,
            'dni' => $this->faker->regexify('[0-9]{8}'),
            'cellphone_1' => $this->faker->numerify('##########'),
            'cellphone_2' => $this->faker->unique()->numerify('##########'),
            'phone' => $this->faker->numerify('+1##########'), // Includes a country code (e.g., +1 for the US)
            'birthdate' => $this->faker->date(),
            'email' => $this->faker->safeEmail(),
            'organization_id' => Organization::factory(),
            'member_position_id' => MemberPosition::factory(),
        ];
    }
}
