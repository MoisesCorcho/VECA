<?php

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Visit;

uses(RefreshDatabase::class);

test('can create a survey answer', function () {
    SurveyAnswer::create([
        'date' => now(),
        'survey_id' => Survey::factory()->create()->id,
        'user_id' => User::factory()->create()->id,
        'visit_id' => Visit::factory()->create()->id
    ]);

    expect(SurveyAnswer::all())->toHaveCount(1)
        ->and(SurveyAnswer::first())->toBeInstanceOf(SurveyAnswer::class)
        ->and(SurveyAnswer::first()->id)->toBeInt()
        ->and(SurveyAnswer::first()->date)->toBeInstanceOf(\DateTimeInterface::class)
        ->and(SurveyAnswer::first()->survey_id)->toBeInt()
        ->and(SurveyAnswer::first()->user_id)->toBeInt();
});

test('can update a survey answer', function () {
    $surveyAnswer = SurveyAnswer::create([
        'date' => now(),
        'survey_id' => Survey::factory()->create()->id,
        'user_id' => User::factory()->create()->id,
        'visit_id' => Visit::factory()->create()->id
    ]);

    $newData = [
        'date' => now()->addDay(),
        'survey_id' => Survey::factory()->create()->id
    ];

    $surveyAnswer->update($newData);

    expect($surveyAnswer)->toBeInstanceOf(SurveyAnswer::class)
        ->and($surveyAnswer->id)->toBeInt()
        ->and($surveyAnswer->date->toDateTimeString())->toBe($newData['date']->toDateTimeString())
        ->and($surveyAnswer->survey_id)->toBe($newData['survey_id']);
});

test('survey answer belongs to a survey', function () {

    $survey = Survey::factory()->create();

    $surveyAnswer = SurveyAnswer::create([
        'date' => now(),
        'survey_id' => $survey->id,
        'user_id' => User::factory()->create()->id,
        'visit_id' => Visit::factory()->create()->id
    ]);

    expect($surveyAnswer->survey)->toBeInstanceOf(Survey::class)
        ->and($surveyAnswer->survey->id)->toBe($survey->id)
        ->and($surveyAnswer->survey->title)->toBe($survey->title);
});
