<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Test Organization Factory
test('organization factory creates valid organizations', function () {
    $organization = Organization::factory()->create();

    expect($organization)->toBeInstanceOf(Organization::class)
        ->and($organization->name)->toBeString()->not->toBeEmpty()
        ->and($organization->description)->toBeString()->not->toBeEmpty()
        ->and($organization->nit)->toBeString()->not->toBeEmpty()
        ->and($organization->cellphone)->toBeString()->not->toBeEmpty()
        ->and($organization->phone)->toBeString()->not->toBeEmpty()
        ->and($organization->email)->toBeString()->toContain('@')
        ->and($organization->user_id)->toBeNumeric();
});

test('organization factory can override default values', function () {
    $customName = 'Custom Company';
    $customDescription = 'Custom company description';
    $customNit = '987-654-321';
    $customCellphone = '9876543210';
    $customPhone = '12345678';
    $customEmail = 'custom@example.com';

    $user = User::factory()->create();

    $organization = Organization::factory()->create([
        'name' => $customName,
        'description' => $customDescription,
        'nit' => $customNit,
        'cellphone' => $customCellphone,
        'phone' => $customPhone,
        'email' => $customEmail,
        'user_id' => $user->id,
    ]);

    expect($organization->name)->toBe($customName)
        ->and($organization->description)->toBe($customDescription)
        ->and($organization->nit)->toBe($customNit)
        ->and($organization->cellphone)->toBe($customCellphone)
        ->and($organization->phone)->toBe($customPhone)
        ->and($organization->email)->toBe($customEmail)
        ->and($organization->user_id)->toBe($user->id);
});

test('organization factory can create multiple organizations', function () {
    $count = 5;
    $organizations = Organization::factory()->count($count)->create();

    expect($organizations)->toHaveCount($count)
        ->and(Organization::count())->toBe($count);
});

test('organization factory creates unique emails', function () {
    $count = 10;
    $organizations = Organization::factory()->count($count)->create();

    $emails = $organizations->pluck('email')->toArray();
    $uniqueEmails = array_unique($emails);

    expect(count($uniqueEmails))->toBe($count);
});

test('organization factory creates organizations for existing user', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->forUser($user)->create();

    expect($organization->user_id)->toBe($user->id)
        ->and($organization->user->id)->toBe($user->id);
});

test('organization factory creates organizations with specified name', function () {
    $name = 'Specific Company Name';
    $organization = Organization::factory()->withName($name)->create();

    expect($organization->name)->toBe($name);
});

test('organization factory creates organizations with specified description', function () {
    $description = 'This is a very specific description for testing purposes';
    $organization = Organization::factory()->withDescription($description)->create();

    expect($organization->description)->toBe($description);
});

test('organization factory creates organizations with specified NIT', function () {
    $nit = '111-222-333';
    $organization = Organization::factory()->withNit($nit)->create();

    expect($organization->nit)->toBe($nit);
});

test('organization factory creates organizations with specified contact info', function () {
    $email = 'specific@example.com';
    $cellphone = '1112223333';
    $phone = '44445555';

    $organization = Organization::factory()
        ->withContactInfo($email, $cellphone, $phone)
        ->create();

    expect($organization->email)->toBe($email)
        ->and($organization->cellphone)->toBe($cellphone)
        ->and($organization->phone)->toBe($phone);
});

test('organization factory chaining works correctly', function () {
    $user = User::factory()->create();
    $name = 'Chain Test Corp';
    $nit = '999-888-777';
    $email = 'chain@example.com';
    $cellphone = '9998887777';

    $organization = Organization::factory()
        ->forUser($user)
        ->withName($name)
        ->withNit($nit)
        ->withContactInfo($email, $cellphone)
        ->create();

    expect($organization->user_id)->toBe($user->id)
        ->and($organization->name)->toBe($name)
        ->and($organization->nit)->toBe($nit)
        ->and($organization->email)->toBe($email)
        ->and($organization->cellphone)->toBe($cellphone);
});
