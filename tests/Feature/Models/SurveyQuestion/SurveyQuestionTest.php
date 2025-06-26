<?php

use App\Models\Survey;
use Illuminate\Support\Str;
use App\Models\SurveyQuestion;
use App\Enums\SurveyQuestionsTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a survey question', function () {

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

    $originalData = json_decode(json_encode($data), true);

    $surveyQuestion = SurveyQuestion::create([
        'type' => SurveyQuestionsTypeEnum::TYPE_RADIO->value,
        'question' => 'Test Question',
        'description' => 'Test Description',
        'data' => $data,
        'survey_id' => $survey->id
    ]);

    expect(SurveyQuestion::all())->toHaveCount(1)
        ->and(SurveyQuestion::first())->toBeInstanceOf(SurveyQuestion::class)
        ->and(SurveyQuestion::first()->id)->toBeInt()
        ->and(SurveyQuestion::first()->type)->toBe(SurveyQuestionsTypeEnum::TYPE_RADIO->value)
        ->and(SurveyQuestion::first()->question)->toBe('Test Question')
        ->and(SurveyQuestion::first()->description)->toBe('Test Description')
        ->and(SurveyQuestion::first()->survey_id)->toBe($survey->id);

    // Detailed structure validation
    expect($surveyQuestion->data)->toBeArray()
        ->and($surveyQuestion->data)->toHaveCount(count($originalData))
        ->and($surveyQuestion->data[0])->toHaveKeys(['uuid', 'text'])
        ->and($surveyQuestion->data[1])->toHaveKeys(['uuid', 'text']);

    // Exact content validation
    expect($surveyQuestion->data[0]['uuid'])->toBe($originalData[0]['uuid'])
        ->and($surveyQuestion->data[0]['text'])->toBe($originalData[0]['text'])
        ->and($surveyQuestion->data[1]['uuid'])->toBe($originalData[1]['uuid'])
        ->and($surveyQuestion->data[1]['text'])->toBe($originalData[1]['text']);
});

test('can update a survey question', function () {
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

    $newData = [
        [
            'uuid' => Str::uuid(),
            'text' => 'New Data 1'
        ],
        [
            'uuid' => Str::uuid(),
            'text' => 'New Data 2'
        ],
        [
            'uuid' => Str::uuid(),
            'text' => 'New Data 3'
        ],
    ];

    $originalNewData = json_decode(json_encode($newData), true);

    $surveyQuestion = SurveyQuestion::create([
        'type' => SurveyQuestionsTypeEnum::TYPE_RADIO->value,
        'question' => 'Test Question',
        'description' => 'Test Description',
        'data' => $data,
        'survey_id' => $survey->id
    ]);

    $surveyQuestion->update([
        'type' => SurveyQuestionsTypeEnum::TYPE_SELECT->value,
        'question' => 'Updated Test Question',
        'description' => 'Updated Test Description',
        'data' => $newData,
        'survey_id' => $survey->id
    ]);

    expect($surveyQuestion)->toBeInstanceOf(SurveyQuestion::class)
        ->and($surveyQuestion->id)->toBeInt()
        ->and($surveyQuestion->type)->toBe(SurveyQuestionsTypeEnum::TYPE_SELECT->value)
        ->and($surveyQuestion->question)->toBe('Updated Test Question')
        ->and($surveyQuestion->description)->toBe('Updated Test Description')
        ->and($surveyQuestion->survey_id)->toBe($survey->id);

    // Detailed structure validation
    expect($surveyQuestion->data)->toBeArray()
        ->and($surveyQuestion->data)->toHaveCount(count($originalNewData))
        ->and($surveyQuestion->data[0])->toHaveKeys(['uuid', 'text'])
        ->and($surveyQuestion->data[1])->toHaveKeys(['uuid', 'text'])
        ->and($surveyQuestion->data[2])->toHaveKeys(['uuid', 'text']);

    // Exact content validation
    expect($surveyQuestion->data[0]['uuid'])->toBe($originalNewData[0]['uuid'])
        ->and($surveyQuestion->data[0]['text'])->toBe($originalNewData[0]['text'])
        ->and($surveyQuestion->data[1]['uuid'])->toBe($originalNewData[1]['uuid'])
        ->and($surveyQuestion->data[1]['text'])->toBe($originalNewData[1]['text'])
        ->and($surveyQuestion->data[2]['uuid'])->toBe($originalNewData[2]['uuid'])
        ->and($surveyQuestion->data[2]['text'])->toBe($originalNewData[2]['text']);
});

test('a survey question belongs to a survey', function () {

    $survey = Survey::factory()->create();

    $surveyQuestion = SurveyQuestion::create([
        'type' => SurveyQuestionsTypeEnum::TYPE_TEXT->value,
        'question' => 'Test Question',
        'description' => 'Test Description',
        'data' => [''],
        'survey_id' => $survey->id
    ]);

    expect($surveyQuestion->survey)->toBeInstanceOf(Survey::class)
        ->and($surveyQuestion->survey->id)->toBe($survey->id)
        ->and($surveyQuestion->survey->title)->toBe($survey->title);
});

test('a survey question can have children', function () {
    $survey = Survey::factory()->create();

    $surveyQuestionParent = SurveyQuestion::factory()->create([
        'survey_id' => $survey->id,
        'parent_id' => null
    ]);

    SurveyQuestion::factory(3)->create([
        'parent_id' => $surveyQuestionParent->id,
        'survey_id' => $survey->id
    ]);

    expect($surveyQuestionParent->children)->toHaveCount(3)
        ->and($surveyQuestionParent->children->first())->toBeInstanceOf(SurveyQuestion::class)
        ->and($surveyQuestionParent->children->first()->parent_id)->toBe($surveyQuestionParent->id);
});

test('a survey question can have a parent', function () {
    $survey = Survey::factory()->create();

    $surveyQuestionParent = SurveyQuestion::factory()->create([
        'survey_id' => $survey->id,
        'parent_id' => null
    ]);

    $surveyQuestionChildren = SurveyQuestion::factory(3)->create([
        'parent_id' => $surveyQuestionParent->id,
        'survey_id' => $survey->id
    ]);

    expect($surveyQuestionChildren->first()->parent)->toBeInstanceOf(SurveyQuestion::class);

    foreach ($surveyQuestionChildren as $surveyQuestionChild) {
        expect($surveyQuestionChild->parent->id)->toBe($surveyQuestionParent->id);
    }
});

test('circular reference is not allowed', function () {
    $survey = Survey::factory()->create();

    $surveyQuestionParent = SurveyQuestion::factory()->create([
        'survey_id' => $survey->id,
        'parent_id' => null
    ]);

    $surveyQuestionParent->update([
        'survey_id' => $survey->id,
        'parent_id' => $surveyQuestionParent->id,
    ]);

    $surveyQuestionParent->save();
})->throws(Exception::class, 'Circular reference detected.');

test('can detect circular reference in update', function () {
    $survey = Survey::factory()->create();

    $surveyQuestionParent = SurveyQuestion::factory()->create([
        'question' => 'Parent Question',
        'survey_id' => $survey->id,
        'parent_id' => null
    ]);

    $maxDepth = $surveyQuestionParent->getMaxDepth();

    $previousQuestion = $surveyQuestionParent;
    for ($i = 0; $i < $maxDepth; $i++) {
        $previousQuestion = SurveyQuestion::factory()->create([
            'survey_id' => $survey->id,
            'parent_id' => $previousQuestion->id
        ]);
    }

    SurveyQuestion::find(2)->update([
        'parent_id' => 2
    ]);
})->throws(Exception::class, 'Circular reference detected.');

test('max depth is working', function () {
    $survey = Survey::factory()->create();

    $surveyQuestionParent = SurveyQuestion::factory()->create([
        'question' => 'Parent Question',
        'survey_id' => $survey->id,
        'parent_id' => null
    ]);

    $maxDepth = $surveyQuestionParent->getMaxDepth();

    $previousQuestion = $surveyQuestionParent;
    for ($i = 0; $i <= $maxDepth; $i++) {
        $previousQuestion = SurveyQuestion::factory()->create([
            'survey_id' => $survey->id,
            'parent_id' => $previousQuestion->id
        ]);
    }
})->throws(Exception::class, 'Maximum depth level reached.');
