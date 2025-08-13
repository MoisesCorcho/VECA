<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Support\Str;
use App\Enums\SurveyQuestionsTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyQuestion>
 */
class SurveyQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(SurveyQuestionsTypeEnum::values()),
            'question' => $this->faker->title(),
            'description' => $this->faker->sentence(),
            'data' => null,
            'survey_id' => Survey::factory(),
            'parent_id' => null,
            'triggering_answer' => null,
            'is_task_trigger' => false,
            'options_source' => 'static',
            'options_model' => null,
            'options_label_column' => null,
        ];
    }

    public function withData(): static
    {
        $data = [
            'Sell / Product Promotion / Credit Documents',
            'Accounts Receivable Collection / Payment Agreements'
        ];

        return $this->state(fn(array $attributes) => [
            'data' => $data,
        ]);
    }
}
