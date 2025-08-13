<?php

use App\Models\User;
use App\Models\Visit;
use App\Models\Organization;
use App\Models\NoVisitReason;
use App\Enums\VisitStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Survey;

uses(RefreshDatabase::class);

test('can create a visit', function () {
    $visitDate = now();
    $rescheduledDate = now()->addDay();

    $organization = Organization::factory()->create();
    $user = User::factory()->create();
    $noVisitReason = NoVisitReason::factory()->create();

    $visit = Visit::create([
        'visit_date' => $visitDate,
        'rescheduled_date' => $rescheduledDate,
        'non_visit_description' => null,
        'status' => VisitStatusEnum::RESCHEDULED,
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'non_visit_reason_id' => $noVisitReason->id
    ]);

    $visit->refresh();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->visit_date->toDateTimeString())->toBe($visitDate->toDateTimeString())
        ->and($visit->rescheduled_date->toDateTimeString())->toBe($rescheduledDate->toDateTimeString())
        ->and($visit->non_visit_description)->toBeNull()
        ->and($visit->status)->toBe(VisitStatusEnum::RESCHEDULED)
        ->and($visit->organization_id)->tobeUuid($organization->id)
        ->and($visit->user_id)->tobeInt($user->id)
        ->and($visit->non_visit_reason_id)->tobeInt($noVisitReason->id);
});

test('can update a visit', function () {
    $visitDate = now();
    $rescheduledDate = now()->addDay();

    $organization = Organization::factory()->create();
    $user = User::factory()->create();

    $visit = Visit::create([
        'visit_date' => $visitDate,
        'rescheduled_date' => null,
        'non_visit_description' => null,
        'status' => VisitStatusEnum::SCHEDULED,
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'non_visit_reason_id' => null
    ]);

    $visit->update([
        'visit_date' => $visitDate,
        'rescheduled_date' => $rescheduledDate,
        'non_visit_description' => null,
        'status' => VisitStatusEnum::RESCHEDULED,
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $visit->refresh();

    expect($visit)->toBeInstanceOf(Visit::class)
        ->and($visit->id)->toBeInt()
        ->and($visit->visit_date->toDateTimeString())->toBe($visitDate->toDateTimeString())
        ->and($visit->rescheduled_date->toDateTimeString())->toBe($rescheduledDate->toDateTimeString())
        ->and($visit->non_visit_description)->toBeNull()
        ->and($visit->status)->toBe(VisitStatusEnum::RESCHEDULED)
        ->and($visit->organization_id)->tobeUuid($organization->id)
        ->and($visit->user_id)->tobeInt($user->id);
});

test('can delete a visit', function () {
    $visit = Visit::factory()->create();

    $visit->delete();

    $this->assertDatabaseMissing('visits', [
        'id' => $visit->id,
    ]);

    expect(Visit::count())->toBe(0);
});

test('a visit belongs to an organization and a user', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create();

    $visit = Visit::factory()->scheduled()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    expect($visit->organization)->toBeInstanceOf(Organization::class)
        ->and($visit->organization->id)->toBe($organization->id)
        ->and($visit->user)->toBeInstanceOf(User::class)
        ->and($visit->user->id)->toBe($user->id);
});

test('a visit can have a non visit reason', function () {
    $noVisitReason = NoVisitReason::factory()->create();

    $visit = Visit::factory()->scheduled()->create([
        'non_visit_reason_id' => $noVisitReason->id,
    ]);

    expect($visit->nonVisitReason)->toBeInstanceOf(NoVisitReason::class)
        ->and($visit->nonVisitReason->id)->toBe($noVisitReason->id);
});
