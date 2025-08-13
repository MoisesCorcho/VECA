<?php

namespace Tests\Support\Helpers;

use App\Filament\Resources\SurveyResource\Pages\CreateSurvey;
use Tests\Support\Helpers\SurveyTestHelpers;

use function Pest\Livewire\livewire;

/**
 * Functions to assert Survey data
 */
class SurveyAssertionsHelpers
{
    /**
     * Assert that task trigger validation fails for given questions
     */
    public static function assertTaskTriggerValidationFails(array $questions): void
    {
        $formData = SurveyTestHelpers::createSurveyData($questions);

        self::assertSurveyCreationFails($formData, ['questions']);
    }

    /**
     * Assert that task trigger validation passes for given questions
     */
    public static function assertTaskTriggerValidationPasses(array $questions): void
    {
        $formData = SurveyTestHelpers::createSurveyData($questions);

        self::assertSurveyCreationPasses($formData);
    }

    /**
     * Assert that survey creation form validation passes
     */
    public static function assertSurveyCreationPasses(array $surveyData): void
    {
        livewire(CreateSurvey::class)
            ->fillForm($surveyData)
            ->call('create')
            ->assertHasNoFormErrors();
    }

    /**
     * Assert that survey creation form validation fails with specific errors
     */
    public static function assertSurveyCreationFails(array $surveyData, array $expectedErrors): void
    {
        livewire(CreateSurvey::class)
            ->fillForm($surveyData)
            ->call('create')
            ->assertHasFormErrors($expectedErrors);
    }
}
