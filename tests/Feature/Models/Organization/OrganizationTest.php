<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create organization using factory', function () {
    $organization = Organization::factory()->create();

    expect($organization)->toBeInstanceOf(Organization::class)
        ->and($organization->id)->toBeUuid()
        ->and($organization->name)->not->toBeEmpty();
});

test('organization has correct fillable attributes', function () {
    $fillable = [
        'name',
        'description',
        'nit',
        'cellphone',
        'phone',
        'email',
        'user_id',
    ];

    expect((new Organization())->getFillable())->toBe($fillable);
});

test('organization belongs to a user', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create(['user_id' => $user->id]);

    expect($organization->user)->toBeInstanceOf(User::class)
        ->and($organization->user->id)->toBe($user->id);
});

test('user can have multiple organizations', function () {
    $user = User::factory()->create();
    Organization::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->organizations)->toHaveCount(3)
        ->each->toBeInstanceOf(Organization::class);
});

test('can create an organization', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'Test Company',
        'description' => 'A test company description',
        'nit' => '123-456-789',
        'cellphone' => '1234567890',
        'phone' => '87654321',
        'email' => 'info@testcompany.com',
        'user_id' => $user->id,
    ];

    $organization = Organization::create($data);

    expect($organization->name)->toBe('Test Company')
        ->and($organization->description)->toBe('A test company description')
        ->and($organization->nit)->toBe('123-456-789')
        ->and($organization->cellphone)->toBe('1234567890')
        ->and($organization->phone)->toBe('87654321')
        ->and($organization->email)->toBe('info@testcompany.com')
        ->and($organization->user_id)->toBe($user->id);
});

test('can update an organization', function () {
    $organization = Organization::factory()->create();

    $newName = 'Updated Company Name';
    $newDescription = 'Updated company description';

    $organization->update([
        'name' => $newName,
        'description' => $newDescription,
    ]);

    $organization->refresh();

    expect($organization->name)->toBe($newName)
        ->and($organization->description)->toBe($newDescription);
});

test('can delete an organization', function () {
    $organization = Organization::factory()->create();
    $id = $organization->id;

    $organization->delete();

    expect(Organization::find($id))->toBeNull();
});

test('can create organization for specific user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $org1 = Organization::factory()->create(['user_id' => $user1->id]);
    $org2 = Organization::factory()->forUser($user2)->create();

    expect($org1->user_id)->toBe($user1->id)
        ->and($org2->user_id)->toBe($user2->id);
});

test('organization requires a name', function () {
    $user = User::factory()->create();

    $data = [
        'description' => 'A test company description',
        'nit' => '123-456-789',
        'cellphone' => '1234567890',
        'phone' => '87654321',
        'email' => 'info@testcompany.com',
        'user_id' => $user->id,
    ];

    expect(fn() => Organization::create($data))
        ->toThrow(Exception::class);
});
