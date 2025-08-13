<?php

use Tests\Support\Helpers\SurveyTestHelpers;
use Tests\Support\Helpers\SurveyDatabaseTestHelpers;
use Tests\Support\Helpers\SurveyAssertionsHelpers;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    // ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function createSurveyData(array $questions): array
{
    return SurveyTestHelpers::createSurveyData($questions);
}

/**
 * NOTE: You can use this function passing options in the data key, only one time per test.
 * This is because Repeaters use UUIDs for their keys. While this can typically be disabled using Repeater::fake(),
 * in this specific case, there are two repeaters involved (the questions repeater and the options repeater for each question),
 * and I don't know how to disable UUID generation for the second repeater (the options repeater).
 */
function createQuestionData(array $overrides = []): array
{
    return SurveyTestHelpers::createQuestionData($overrides);
}

function assertTaskTriggerValidationFails(array $questions): void
{
    SurveyAssertionsHelpers::assertTaskTriggerValidationFails($questions);
}

function assertTaskTriggerValidationPasses(array $questions): void
{
    SurveyAssertionsHelpers::assertTaskTriggerValidationPasses($questions);
}

function assertSurveyCreationPasses(array $surveyData): void
{
    SurveyAssertionsHelpers::assertSurveyCreationPasses($surveyData);
}

function assertSurveyCreationFails(array $surveyData, array $expectedErrors): void
{
    SurveyAssertionsHelpers::assertSurveyCreationFails($surveyData, $expectedErrors);
}

function assertSurveyNotPersisted(array $surveyData): void
{
    SurveyDatabaseTestHelpers::assertSurveyNotPersisted($surveyData);
}

function assertSurveyPersisted(array $surveyData): void
{
    SurveyDatabaseTestHelpers::assertSurveyPersisted($surveyData);
}

function assertQuestionWasCreated(array $questionData): void
{
    SurveyDatabaseTestHelpers::assertQuestionWasCreated($questionData);
}
