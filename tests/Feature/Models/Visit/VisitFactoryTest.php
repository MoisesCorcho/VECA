<?php

use App\Models\Visit;
use App\Enums\VisitStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a visit with factory', function () {
    $visit = Visit::factory()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt();
});

test('can create a scheduled visit with factory', function () {
    $visit = Visit::factory()->scheduled()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->status)->toBe(VisitStatusEnum::SCHEDULED);
});

test('can create a not visited visit with factory', function () {
    $visit = Visit::factory()->notVisited()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->status)->toBe(VisitStatusEnum::NOT_VISITED);
});

test('can create a canceled visit with factory', function () {
    $visit = Visit::factory()->canceled()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->status)->toBe(VisitStatusEnum::CANCELED);
});

test('can create a rescheduled visit with factory', function () {
    $visit = Visit::factory()->rescheduled()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->status)->toBe(VisitStatusEnum::RESCHEDULED);
});

test('can create a visited visit with factory', function () {
    $visit = Visit::factory()->visited()->create();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->status)->toBe(VisitStatusEnum::VISITED);
});
