<?php

use function Pest\Livewire\livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Filament\Resources\SurveyResource\Pages\CreateSurvey;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PermissionSeeder;
use App\Models\User;
use App\Filament\Resources\SurveyResource\Pages\ListSurveys;
use Filament\Forms\Components\Repeater;
use App\Enums\SurveyQuestionsTypeEnum;
use App\Models\Survey;
use App\Filament\Resources\SurveyResource\Pages\EditSurvey;
use App\Models\SurveyQuestion;
use App\Models\Organization;
use Database\Seeders\SurveySeeder;
use Database\Seeders\SurveyQuestionSeeder;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $this->seed(PermissionSeeder::class);

    // Acting as super admin
    actingAs(User::where('email', 'jorge@gmail.com')->first());
});

it('can display the page', function () {
    Livewire(CreateSurvey::class)
        ->assertSuccessful();
});

it('has column', function (string $column) {
    livewire(ListSurveys::class)
        ->assertTableColumnExists($column);
})->with(['title', 'status', 'questions_count']);

test('form has fields', function (string $field) {
    livewire(CreateSurvey::class)
        ->assertFormFieldExists($field);
})->with(['title', 'description', 'status', 'questions']);

test('a survey can be created with diferent question types', function () {
    Repeater::fake();

    // Arrange
    $options = [
        ['option' => 'Good'],
        ['option' => 'Bad'],
    ];

    $selectQuestion = createQuestionData([
        'type' => 'select',
        'data' => $options,
    ]);

    $textAreaQuestion = createQuestionData([
        'type' => 'textarea',
        'is_task_trigger' => true,
    ]);

    $formData = createSurveyData([
        $selectQuestion,
        $textAreaQuestion
    ]);

    // Act
    assertSurveyCreationPasses($formData);

    // Assert
    assertSurveyPersisted($formData);
});

describe('Survey Creation - Form Validation', function () {
    beforeEach(fn() => Repeater::fake());

    test('fails when question type is missing', function () {
        $formData = createSurveyData([
            createQuestionData(['type' => null])
        ]);

        assertSurveyCreationFails($formData, ['questions.0.type' => 'required']);
    });

    test('fails when question text is empty', function () {
        $formData = createSurveyData([
            createQuestionData(['question' => ''])
        ]);

        assertSurveyCreationFails($formData, ['questions.0.question' => 'required']);
    });
});

describe('Survey Creation - Task Trigger Validation', function () {
    beforeEach(fn() => Repeater::fake());

    test('fails when no question has task trigger enabled', function () {
        $questions = [
            createQuestionData(['is_task_trigger' => false]),
            createQuestionData(['is_task_trigger' => false])
        ];

        assertTaskTriggerValidationFails($questions);
    });

    test('passes when exactly one question has task trigger enabled', function () {
        $questions = [
            createQuestionData(['is_task_trigger' => true]),
            createQuestionData(['is_task_trigger' => false])
        ];

        assertTaskTriggerValidationPasses($questions);
    });

    test('fails when multiple questions have task trigger enabled', function () {
        $questions = [
            createQuestionData(['is_task_trigger' => true]),
            createQuestionData(['is_task_trigger' => true]),
            createQuestionData(['is_task_trigger' => true])
        ];

        assertTaskTriggerValidationFails($questions);
    });

    test('fails when checkbox question has task trigger enabled', function () {
        $questions = [
            createQuestionData([
                'type' => SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value,
                'is_task_trigger' => true,
                'data' => [
                    ['option' => 'Option 1'],
                    ['option' => 'Option 2']
                ]
            ])
        ];

        assertTaskTriggerValidationFails($questions);
    });
});

describe('Survey Creation - Database Persistence', function () {
    beforeEach(fn() => Repeater::fake());

    test('creates survey and questions when validation passes', function () {
        $questions = [
            createQuestionData(['is_task_trigger' => true]),
            createQuestionData(['is_task_trigger' => false])
        ];

        $surveyData = createSurveyData($questions);

        assertSurveyCreationPasses($surveyData);

        assertSurveyPersisted($surveyData, $questions);
    });

    test('does not create survey when validation fails', function () {
        $questions = [
            createQuestionData(['type' => null])
        ];

        $surveyData = createSurveyData($questions);

        assertSurveyCreationFails($surveyData, [
            'questions' => 'At least one question must be marked to generate pending tasks.',
            'questions.0.type' => 'required'
        ]);

        assertSurveyNotPersisted($surveyData);
    });
});

describe('Survey Creation - Database Persistence', function () {

    beforeEach(fn() => Repeater::fake());

    test('can create survey with question of type', function ($type) {
        $options = [
            ['option' => 'Good'],
            ['option' => 'Bad'],
        ];

        if (in_array($type->value, $type->nonOptionsTypes())) {
            $questionData =
                createQuestionData([
                    'type' => $type->value,
                    'is_task_trigger' => true,
                ]);
        } else {
            $questionData =
                createQuestionData([
                    'type' => $type->value,
                    'is_task_trigger' => true,
                    'data' => $options,
                ]);
        }

        $surveyData = createSurveyData([
            $questionData
        ]);

        livewire(CreateSurvey::class)
            ->fillForm($surveyData)
            ->call('create')
            ->assertHasNoFormErrors();

        // Assert
        assertSurveyPersisted($surveyData);
    })->with([
        SurveyQuestionsTypeEnum::TYPE_TEXT,
        SurveyQuestionsTypeEnum::TYPE_TEXTAREA,
        SurveyQuestionsTypeEnum::TYPE_SELECT,
        SurveyQuestionsTypeEnum::TYPE_RADIO,
        SurveyQuestionsTypeEnum::TYPE_DATE,
        SurveyQuestionsTypeEnum::TYPE_TIME,
    ]);

    /**
     * Checkbox question is a special case because it cannot be a task trigger
     * And a survey always needs to have at least one task trigger
     */
    test('can create survey with checkbox question and separate task trigger', function () {
        Repeater::fake();

        $options = [
            ['option' => 'Good'],
            ['option' => 'Bad'],
        ];

        $questionData = [
            createQuestionData([
                'type' => SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value,
                'is_task_trigger' => false,
                'data' => $options,
            ]),
            createQuestionData([
                'type' => SurveyQuestionsTypeEnum::TYPE_TEXT->value,
                'is_task_trigger' => true,
            ]),
        ];

        $surveyData = createSurveyData($questionData);

        livewire(CreateSurvey::class)
            ->fillForm($surveyData)
            ->call('create')
            ->assertHasNoFormErrors();

        // Assert
        assertSurveyPersisted($surveyData);
    });
});

describe('Survey Creation - Options Validation', function () {
    beforeEach(fn() => Repeater::fake());

    test('fails when select question has empty option text', function () {
        $selectQuestion = createQuestionData([
            'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
            'is_task_trigger' => true,
            'data' => [
                ['option' => '']
            ],
        ]);

        $surveyData = createSurveyData([$selectQuestion]);

        assertSurveyCreationFails($surveyData, [
            'questions.0.data.0.option' => 'required'
        ]);
    });

    test('passes when text question has null data', function () {
        $textQuestion = createQuestionData([
            'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
            'is_task_trigger' => true,
            'data' => null,
        ]);

        $surveyData = createSurveyData([
            $textQuestion
        ]);

        assertSurveyCreationPasses($surveyData);

        assertSurveyPersisted($surveyData);
    });
});

describe('Survey Creation - Database Options', function () {
    beforeEach(fn() => Repeater::fake());

    test('can create question with database options source', function () {
        $questionData = createQuestionData([
            'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
            'is_task_trigger' => true,
            'options_source' => 'database',
            'options_model' => Organization::class,
            'options_label_column' => 'name',
            'data' => null,
        ]);

        $surveyData = createSurveyData([
            $questionData
        ]);

        assertSurveyCreationPasses($surveyData);
        assertSurveyPersisted($surveyData);
    });

    test('fails when database option model is missing', function () {
        $questionData = createQuestionData([
            'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
            'is_task_trigger' => true,
            'options_source' => 'database',
            'options_model' => null,
            'options_label_column' => null,
        ]);

        $surveyData = createSurveyData([
            $questionData
        ]);

        assertSurveyCreationFails($surveyData, [
            'questions.0.options_model' => 'required',
        ]);
    });

    test('fails when database option label column is missing', function () {
        $questionData = createQuestionData([
            'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
            'is_task_trigger' => true,
            'options_source' => 'database',
            'options_model' => Organization::class,
            'options_label_column' => null,
        ]);

        $surveyData = createSurveyData([
            $questionData
        ]);

        assertSurveyCreationFails($surveyData, [
            'questions.0.options_label_column' => 'required',
        ]);
    });
});

describe('Survey Creation - Authorization', function () {
    beforeEach(fn() => Repeater::fake());

    test('prevents unauthorized user from creating survey', function () {
        // Acting as unauthorized user
        actingAs(User::factory()->create());

        $surveyData = createSurveyData([
            createQuestionData([
                'is_task_trigger' => true
            ])
        ]);

        livewire(CreateSurvey::class)
            ->assertForbidden();
    });
});
