<?php

use App\Models\User;
use App\Models\Survey;
use Illuminate\Support\Str;
use App\Models\SurveyQuestion;
use App\Enums\SurveyQuestionsTypeEnum;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('can create a survey', function () {
    $survey = Survey::create([
        'title' => 'Test Survey',
        'description' => 'Test Survey Description',
        'status' => true,
        'user_id' => User::factory()->create()->id,
    ]);

    $this->assertDatabaseHas('surveys', [
        'title' => $survey->title,
        'description' => $survey->description,
        'status' => $survey->status,
        'user_id' => $survey->user_id,
    ]);

    expect(Survey::all())->toHaveCount(1)
        ->and($survey)->toBeInstanceOf(Survey::class)
        ->and($survey->id)->toBeInt()
        ->and($survey->title)->toBe('Test Survey')
        ->and($survey->description)->toBe('Test Survey Description')
        ->and($survey->status)->toBe(true)
        ->and($survey->user_id)->toBeInt();
});

test('can update a survey', function () {
    $survey = Survey::create([
        'title' => 'Test Survey',
        'description' => 'Test Survey Description',
        'status' => true,
        'user_id' => User::factory()->create()->id,
    ]);

    $survey->update([
        'title' => 'Updated Survey',
        'description' => 'Updated Survey Description',
        'status' => false,
        'user_id' => User::factory()->create()->id,
    ]);

    expect($survey)->toBeInstanceOf(Survey::class)
        ->and($survey->id)->toBeInt()
        ->and($survey->title)->toBe('Updated Survey')
        ->and($survey->description)->toBe('Updated Survey Description')
        ->and($survey->status)->toBe(false)
        ->and($survey->user_id)->toBeInt();
});

test('can delete a survey', function () {
    $survey = Survey::create([
        'title' => 'Test Survey',
        'description' => 'Test Survey Description',
        'status' => true,
        'user_id' => User::factory()->create()->id,
    ]);

    $survey->delete();

    expect($survey)->toBeInstanceOf(Survey::class)
        ->and($survey->id)->toBeInt()
        ->and($survey->title)->toBe('Test Survey')
        ->and($survey->description)->toBe('Test Survey Description')
        ->and($survey->status)->toBe(true)
        ->and($survey->user_id)->toBeInt()
        ->and($survey->deleted_at)->not()->toBeNull();

    expect(Survey::all())->toHaveCount(0);

    $this->assertSoftDeleted('surveys', [
        'title' => $survey->title,
        'description' => $survey->description,
        'status' => $survey->status,
        'user_id' => $survey->user_id,
    ]);
});

test('can restore a survey', function () {
    $survey = Survey::create([
        'title' => 'Test Survey',
        'description' => 'Test Survey Description',
        'status' => true,
        'user_id' => User::factory()->create()->id,
    ]);

    $survey->delete();
    $survey->restore();

    expect($survey)->toBeInstanceOf(Survey::class)
        ->and($survey->id)->toBeInt()
        ->and($survey->title)->toBe('Test Survey')
        ->and($survey->description)->toBe('Test Survey Description')
        ->and($survey->status)->toBe(true)
        ->and($survey->user_id)->toBeInt()
        ->and($survey->deleted_at)->toBeNull();

    expect(Survey::all())->toHaveCount(1);
});

test('can force delete a survey', function () {
    $survey = Survey::create([
        'title' => 'Test Survey',
        'description' => 'Test Survey Description',
        'status' => true,
        'user_id' => User::factory()->create()->id,
    ]);

    $survey->delete();
    $survey->forceDelete();

    expect($survey)->toBeInstanceOf(Survey::class)
        ->and($survey->id)->toBeInt()
        ->and($survey->title)->toBe('Test Survey')
        ->and($survey->description)->toBe('Test Survey Description')
        ->and($survey->status)->toBe(true)
        ->and($survey->user_id)->toBeInt();

    expect(Survey::withTrashed()->get())->toHaveCount(0);
});

test('a survey can have questions with preserved data structure', function () {
    $survey = Survey::factory()->create();

    $data = [
        [
            'uuid' => Str::uuid(),
            'text' => 'Sell / Product Promotion / Credit Documents'
        ],
        [
            'uuid' => Str::uuid(),
            'text' => 'Accounts Receivable Collection / Payment Agreements'
        ],
    ];

    // We save a copy of the original array to compare
    $originalData = json_decode(json_encode($data), true);

    // We convert the UUIDs to string to direct comparison
    $originalData[0]['uuid'] = $data[0]['uuid']->toString();
    $originalData[1]['uuid'] = $data[1]['uuid']->toString();

    $survey->questions()->create([
        'type' => SurveyQuestionsTypeEnum::TYPE_RADIO->value,
        'question' => 'Test Question',
        'description' => 'Test Description',
        'data' => $data,
    ]);

    $retrievedQuestion = $survey->questions()->first();
    $retrievedData = $retrievedQuestion->data;

    expect($survey->questions)->toHaveCount(1)
        ->and($retrievedQuestion)->toBeInstanceOf(SurveyQuestion::class)
        ->and($retrievedQuestion->id)->toBeInt()
        ->and($retrievedQuestion->type)->toBe('radio')
        ->and($retrievedQuestion->question)->toBe('Test Question')
        ->and($retrievedQuestion->description)->toBe('Test Description');

    // Detailed structure validation
    expect($retrievedData)->toBeArray()
        ->and($retrievedData)->toHaveCount(count($originalData))
        ->and($retrievedData[0])->toHaveKeys(['uuid', 'text'])
        ->and($retrievedData[1])->toHaveKeys(['uuid', 'text']);

    // Exact content validation
    expect($retrievedData[0]['uuid'])->toBe($originalData[0]['uuid'])
        ->and($retrievedData[0]['text'])->toBe($originalData[0]['text'])
        ->and($retrievedData[1]['uuid'])->toBe($originalData[1]['uuid'])
        ->and($retrievedData[1]['text'])->toBe($originalData[1]['text']);

    // A entire structure is validated with a direct comparison
    expect($retrievedData)->toBe($originalData);
});

test('a survey can have answers', function () {
    $survey = Survey::factory()->create();
    $user = User::factory()->create();

    $date = now();
    $date2 = now()->addDay();

    $visit1 = Visit::factory()->scheduled()->create([
        'user_id' => $user->id
    ]);

    $visit2 = Visit::factory()->scheduled()->create([
        'user_id' => $user->id
    ]);

    $surveyAnswer1 = $survey->answers()->create([
        'date' => $date,
        'user_id' => $user->id,
        'visit_id' => $visit1->id
    ]);

    $surveyAnswer2 = $survey->answers()->create([
        'date' => $date2,
        'user_id' => $user->id,
        'visit_id' => $visit2->id
    ]);

    expect($survey->answers)->toHaveCount(2)
        ->and($surveyAnswer1->date->toDateTimeString())->toBe($date->toDateTimeString())
        ->and($surveyAnswer1->survey_id)->toBe($survey->id)
        ->and($surveyAnswer1->visit_id)->toBe($visit1->id)
        ->and($surveyAnswer2->date->toDateTimeString())->toBe($date2->toDateTimeString())
        ->and($surveyAnswer2->survey_id)->toBe($survey->id)
        ->and($surveyAnswer2->visit_id)->toBe($visit2->id);
});
