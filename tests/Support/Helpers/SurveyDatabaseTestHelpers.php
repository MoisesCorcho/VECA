<?php

namespace Tests\Support\Helpers;

use App\Models\Survey;
use App\Models\SurveyQuestion;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use App\Enums\SurveyQuestionsTypeEnum;

/**
 * Functions to verify Survey data persisted in database
 */
class SurveyDatabaseTestHelpers
{
    /**
     * Assert survey and all questions were NOT created in database
     */
    public static function assertSurveyNotPersisted(array $surveyData): void
    {
        self::assertSurveyWasNotCreated($surveyData);

        self::assertQuestionWasNotCreated($surveyData['questions']);
    }

    /**
     * Assert survey and all questions were persisted successfully
     */
    public static function assertSurveyPersisted(array $surveyData): void
    {
        self::assertSurveyWasCreated($surveyData);

        self::assertQuestionWasCreated($surveyData['questions']);
    }

    /**
     * Assert question(s) were created correctly depending on their type.
     */
    public static function assertQuestionWasCreated(array $questionData): void
    {
        foreach ($questionData as $question) {
            self::assertSingleQuestionWasCreated($question);
        }
    }

    /**
     * Assert question(s) were NOT created correctly depending on their type.
     */
    public static function assertQuestionWasNotCreated(array $questionData): void
    {
        foreach ($questionData as $question) {
            self::assertSingleQuestionWasNotCreated($question);
        }
    }

    /**
     * Assert survey was created in database
     */
    private static function assertSurveyWasCreated(array $surveyData): void
    {
        assertDatabaseHas(Survey::class, [
            'title' => $surveyData['title'],
            'description' => $surveyData['description'],
            'status' => $surveyData['status'],
        ]);
    }

    /**
     * Assert survey was NOT created in database
     */
    private static function assertSurveyWasNotCreated(array $surveyData): void
    {
        assertDatabaseMissing(Survey::class, [
            'title' => $surveyData['title'],
            'description' => $surveyData['description'],
            'status' => $surveyData['status'],
        ]);
    }

    /**
     * Assert a single question with options was created correctly.
     */
    private static function assertOptionsQuestionWasCreated(array $questionData): void
    {
        assertDatabaseHas(SurveyQuestion::class, [
            'type' => $questionData['type'],
            'question' => $questionData['question'],
            'description' => $questionData['description'],
            'is_task_trigger' => $questionData['is_task_trigger'],
            'data' => $questionData['data'],
            'parent_id' => $questionData['parent_id'],
            'triggering_answer' => $questionData['triggering_answer'],
            "options_source" => $questionData['options_source'],
            "options_model" => $questionData['options_model'],
            "options_label_column" => $questionData['options_label_column']
        ]);

        $question = SurveyQuestion::where('question', $questionData['question'])->first();
        $expectedOptions = array_column($questionData['data'], 'option');

        expect($question)
            ->data->toBeArray()
            ->data->toHaveCount(count($expectedOptions))
            ->type->toBe($questionData['type']);
    }

    /**
     * Assert a single question with options was NOT created correctly.
     */
    private static function assertOptionsQuestionWasNotCreated(array $questionData): void
    {
        assertDatabaseMissing(SurveyQuestion::class, [
            'type' => $questionData['type'],
            'question' => $questionData['question'],
            'description' => $questionData['description'],
            'is_task_trigger' => $questionData['is_task_trigger'],
            'data' => $questionData['data'],
            'parent_id' => $questionData['parent_id'],
            'triggering_answer' => $questionData['triggering_answer'],
            "options_source" => $questionData['options_source'],
            "options_model" => $questionData['options_model'],
            "options_label_column" => $questionData['options_label_column']
        ]);

        $question = SurveyQuestion::where('question', $questionData['question'])->first();

        expect($question)
            ->data->toBeNull();
    }

    /**
     * Assert a single question without options was created correctly.
     */
    private static function assertNonOptionsQuestionWasCreated(array $questionData): void
    {
        assertDatabaseHas(SurveyQuestion::class, [
            'type' => $questionData['type'],
            'question' => $questionData['question'],
            'is_task_trigger' => $questionData['is_task_trigger'],
        ]);
    }

    /**
     * Assert a single question without options was NOT created correctly.
     */
    private static function assertNonOptionsQuestionWasNotCreated(array $questionData): void
    {
        assertDatabaseMissing(SurveyQuestion::class, [
            'type' => $questionData['type'],
            'question' => $questionData['question'],
            'is_task_trigger' => $questionData['is_task_trigger'],
        ]);
    }

    /**
     * Assert a single question based on its type.
     */
    private static function assertSingleQuestionWasCreated(array $questionData): void
    {
        $nonOptionsTypes = array_column(SurveyQuestionsTypeEnum::nonOptionsTypes(), 'value');
        $isOptionsType = in_array($questionData['type'], $nonOptionsTypes);

        if ($isOptionsType) {
            self::assertOptionsQuestionWasCreated($questionData);
        } else {
            self::assertNonOptionsQuestionWasCreated($questionData);
        }
    }

    /**
     * Assert a single question based on its type.
     */
    private static function assertSingleQuestionWasNotCreated(array $questionData): void
    {
        $nonOptionsTypes = array_column(SurveyQuestionsTypeEnum::nonOptionsTypes(), 'value');
        $isNonOptionsType = in_array($questionData['type'], $nonOptionsTypes);

        if ($isNonOptionsType) {
            self::assertNonOptionsQuestionWasNotCreated($questionData);
        } else {
            self::assertOptionsQuestionWasNotCreated($questionData);
        }
    }
}
