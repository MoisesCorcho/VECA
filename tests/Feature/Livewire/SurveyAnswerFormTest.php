<?php

use App\Models\User;
use App\Models\Visit;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use App\Livewire\SurveyAnswerForm;
use App\Enums\SurveyQuestionsTypeEnum;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\VisitStatusEnum;
use Filament\Notifications\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);
uses()->group('livewire', 'survey');

beforeEach(function () {

    $this->seed(RoleSeeder::class);
    $this->seed(UserSeeder::class);
    $this->seed(PermissionSeeder::class);

    actingAs(User::where('email', 'jorge@gmail.com')->first());

    $this->survey = Survey::factory()->create([
        'title' => 'Test Survey',
        'description' => 'Test Description'
    ]);

    $this->visit = Visit::factory()->scheduled()->create();

    $this->parentQuestion = SurveyQuestion::factory()->create([
        'survey_id' => $this->survey->id,
        'question' => 'Parent Question',
        'type' => SurveyQuestionsTypeEnum::TYPE_RADIO->value,
        'data' => [
            'option' => 'Yes',
            'option' => 'No'
        ],
        'parent_id' => null,
    ]);

    $this->dependentQuestion = SurveyQuestion::factory()->create([
        'survey_id' => $this->survey->id,
        'question' => 'Dependent Question',
        'type' => SurveyQuestionsTypeEnum::TYPE_TEXT->value,
        'parent_id' => $this->parentQuestion->id,
        'triggering_answer' => 'Yes',
    ]);

    $this->checkboxQuestion = SurveyQuestion::factory()->create([
        'survey_id' => $this->survey->id,
        'question' => 'Checkbox Question',
        'type' => SurveyQuestionsTypeEnum::TYPE_CHECKBOX->value,
        'data' => [
            'option' => 'Option 1',
            'option' => 'Option 2'
        ],
        'parent_id' => null,
    ]);
});

it('renders successfully and hides dependent questions initially', function () {
    $component = Livewire(SurveyAnswerForm::class, [
        'survey' => $this->survey,
        'visit' => $this->visit
    ]);

    $component->assertStatus(200)
        ->assertSee($this->survey->title)
        ->assertSee($this->survey->description)
        ->assertSee($this->parentQuestion->question)
        ->assertSee($this->checkboxQuestion->question)
        ->assertDontSee($this->dependentQuestion->question);

    $questions = $this->survey->questions;

    $component
        ->assertViewHas('questions', function () use ($questions) {
            return count($questions) == 3;
        });
});

it('shows dependent question when parent answer is selected', function () {
    $component = Livewire(SurveyAnswerForm::class, [
        'survey' => $this->survey,
        'visit' => $this->visit
    ]);

    // Simulates selecting the 'Yes' answer for the parent question
    $component->set('answers.' . $this->parentQuestion->id, 'Yes');

    $component->assertSee($this->dependentQuestion->question);
});

it('saves the survey answers and redirects to calendar', function () {

    $component = livewire(SurveyAnswerForm::class, [
        'survey' => $this->survey,
        'visit' => $this->visit
    ])
        ->set('answers.' . $this->parentQuestion->id, 'Yes')
        ->set('answers.' . $this->dependentQuestion->id, 'Respuesta a la pregunta dependiente')
        ->set('answers.' . $this->checkboxQuestion->id, [
            'Option 1' => true
        ]);

    $component->call('save');

    $this->assertDatabaseCount('survey_answers', 1);
    $this->assertDatabaseCount('survey_question_answers', 3);

    $this->assertDatabaseHas('survey_question_answers', [
        'answer' => json_encode('Yes'),
    ])
        ->assertDatabaseHas('survey_question_answers', [
            'answer' => json_encode('Respuesta a la pregunta dependiente'),
        ])
        ->assertDatabaseHas('survey_question_answers', [
            'answer' => json_encode(['Option 1']),
        ]);

    $this->visit->refresh();
    $this->assertEquals(VisitStatusEnum::VISITED, $this->visit->status);

    $component
        ->assertNotified(
            Notification::make()
                ->success()
                ->title('Success')
                ->body('Answer saved successfully')
                ->send(),
        );

    $component->assertRedirectToRoute('filament.user.pages.calendar');
});

it('visible questions are required', function () {

    $component = livewire(SurveyAnswerForm::class, [
        'survey' => $this->survey,
        'visit' => $this->visit
    ])
        ->set('answers.' . $this->parentQuestion->id, '')
        ->set('answers.' . $this->dependentQuestion->id, 'Respuesta a la pregunta dependiente')
        ->set('answers.' . $this->checkboxQuestion->id, [
            'Option 1' => true
        ]);

    $component->call('save')
        ->assertHasErrors(['answers.' . $this->parentQuestion->id]);
});

it('child questions are not required if parent question is not selected', function () {

    $component = livewire(SurveyAnswerForm::class, [
        'survey' => $this->survey,
        'visit' => $this->visit
    ])
        ->set('answers.' . $this->parentQuestion->id, 'No')
        ->set('answers.' . $this->dependentQuestion->id, '')
        ->set('answers.' . $this->checkboxQuestion->id, [
            'Option 1' => true
        ]);

    $component->call('save');

    $this->assertDatabaseCount('survey_answers', 1);
    $this->assertDatabaseCount('survey_question_answers', 3);

    $this->assertDatabaseHas('survey_question_answers', [
        'answer' => json_encode('No'),
    ])
        ->assertDatabaseHas('survey_question_answers', [
            'answer' => json_encode(''),
        ])
        ->assertDatabaseHas('survey_question_answers', [
            'answer' => json_encode(['Option 1']),
        ]);

    $this->visit->refresh();
    $this->assertEquals(VisitStatusEnum::VISITED, $this->visit->status);

    $component
        ->assertNotified(
            Notification::make()
                ->success()
                ->title('Success')
                ->body('Answer saved successfully')
                ->send(),
        );

    $component->assertRedirectToRoute('filament.user.pages.calendar');
});
