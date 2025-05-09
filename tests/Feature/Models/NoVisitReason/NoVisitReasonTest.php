<?php

use App\Models\Visit;
use App\Models\NoVisitReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

uses(RefreshDatabase::class);

test('can create a no visit reason', function () {
    $noVisitReason = NoVisitReason::factory()->create([
        'reason' => 'Test Reason',
    ]);

    expect($noVisitReason)->toBeInstanceOf(NoVisitReason::class)
        ->and($noVisitReason->reason)->toEqual('Test Reason');
});

test('can update a no visit reason', function () {
    $noVisitReason = NoVisitReason::factory()->create([
        'reason' => 'Test Reason',
    ]);

    $noVisitReason->update([
        'reason' => 'Updated Reason',
    ]);

    $noVisitReason->refresh();

    expect($noVisitReason)->toBeInstanceOf(NoVisitReason::class)
        ->and($noVisitReason->reason)->toEqual('Updated Reason');
});

test('a no visit reason can have visits associated', function () {
    $noVisitReason = NoVisitReason::factory()->create();

    Visit::factory()->count(3)->create([
        'non_visit_reason_id' => $noVisitReason->id,
    ]);

    expect($noVisitReason->visits())->toBeInstanceOf(HasMany::class)
        ->and($noVisitReason->visits->count())->toBe(3);
});
