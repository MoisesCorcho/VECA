<?php

namespace Database\Factories;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyQuestionAnswer>
 */
class SurveyQuestionAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'answer' => json_encode([$this->faker->word()]),
            'survey_question_id' => SurveyQuestion::factory(),
            'survey_answer_id' => SurveyAnswer::factory(),
        ];
    }
}
