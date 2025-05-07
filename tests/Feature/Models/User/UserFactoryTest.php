<?php

use App\Enums\DniType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user factory creates valid users', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBeString()->not->toBeEmpty()
        ->and($user->email)->toBeString()->toContain('@')
        ->and($user->password)->toBeString()->not->toBeEmpty()
        ->and($user->remember_token)->toBeNull();
});

test('user factory can override default values', function () {
    $customName = 'Custom Name';
    $customEmail = 'custom@example.com';
    $customLastName = 'Custom Last';
    $customCellphone = '9876543210';
    $customDniType = DniType::TI;
    $customDni = '87654321';
    $customActive = false;
    $customVisitsPerDay = 10;

    $user = User::factory()->create([
        'name' => $customName,
        'email' => $customEmail,
        'last_name' => $customLastName,
        'cellphone' => $customCellphone,
        'dni_type' => $customDniType,
        'dni' => $customDni,
        'active' => $customActive,
        'visits_per_day' => $customVisitsPerDay,
    ]);

    expect($user->name)->toBe($customName)
        ->and($user->email)->toBe($customEmail)
        ->and($user->last_name)->toBe($customLastName)
        ->and($user->cellphone)->toBe($customCellphone)
        ->and($user->dni_type)->toBe($customDniType)
        ->and($user->dni)->toBe($customDni)
        ->and($user->active)->toBe($customActive)
        ->and($user->visits_per_day)->toBe($customVisitsPerDay);
});

test('user factory can create multiple users', function () {
    $count = 5;
    $users = User::factory()->count($count)->create();

    expect($users)->toHaveCount($count)
        ->and(User::count())->toBe($count);
});

test('user factory creates unique emails', function () {
    $count = 10;
    $users = User::factory()->count($count)->create();

    $emails = $users->pluck('email')->toArray();
    $uniqueEmails = array_unique($emails);

    expect(count($uniqueEmails))->toBe($count);
});

test('user factory can create verified users', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    expect($user->email_verified_at)->not->toBeNull()
        ->and($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
});
