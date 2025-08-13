<?php

namespace Tests\Support\Helpers;

use App\Enums\SurveyQuestionsTypeEnum;

/**
 * Functions for creating test data
 */
class SurveyTestHelpers
{
    /**
     * Creates survey form data for testing
     */
    public static function createSurveyData(array $questions): array
    {
        return [
            'title' => 'Test Survey',
            'status' => true,
            'description' => null,
            'questions' => $questions,
        ];
    }

    /**
     * Creates question data with defaults and overrides
     */
    public static function createQuestionData(array $overrides = []): array
    {
        $defaults = [
            'type' => SurveyQuestionsTypeEnum::TYPE_TEXT->value,
            'question' => fake()->sentence(),
            'description' => null,
            'is_task_trigger' => false,
            'data' => null,
            'parent_id' => null,
            'triggering_answer' => null,
            'options_source' => 'static',
            'options_model' => null,
            'options_label_column' => null,
        ];

        return array_merge($defaults, $overrides);
    }
}
