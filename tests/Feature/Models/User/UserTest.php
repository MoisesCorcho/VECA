<?php

use App\Enums\DniType;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create user using factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->toBeNumeric()
        ->and($user->name)->not->toBeEmpty()
        ->and($user->email)->toBeString()->toContain('@');
});

test('user has correct fillable attributes', function () {
    $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'cellphone',
        'dni_type',
        'dni',
        'active',
        'visits_per_day',
        'survey_id',
    ];

    expect((new User())->getFillable())->toBe($fillable);
});

test('user has correct hidden attributes', function () {
    $hidden = [
        'password',
        'remember_token',
    ];

    expect((new User())->getHidden())->toBe($hidden);
});

test('user has correct casts', function () {
    $user = new User();

    expect($user->getCasts())
        ->toHaveKey('email_verified_at', 'datetime')
        ->toHaveKey('password', 'hashed');
});

test('initials method returns correct initials', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    expect($user->initials())->toBe('JD');

    $user = User::factory()->create(['name' => 'Jane Marie Smith']);
    expect($user->initials())->toBe('JMS');

    $user = User::factory()->create(['name' => 'Alex']);
    expect($user->initials())->toBe('A');
});

test('user can have many organizations', function () {
    $user = User::factory()->create();
    Organization::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->organizations)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Organization::class);
});

test('can create a user', function () {
    $userData = [
        'name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password123',
        'cellphone' => '1234567890',
        'dni_type' => DniType::CC->value,
        'dni' => '12345678',
        'active' => true,
        'visits_per_day' => 5,
    ];

    $user = User::create($userData);

    expect($user->name)->toBe('John')
        ->and($user->last_name)->toBe('Doe')
        ->and($user->email)->toBe('john.doe@example.com')
        ->and($user->cellphone)->toBe('1234567890')
        ->and($user->dni_type)->toBe(DniType::CC)
        ->and($user->dni)->toBe('12345678')
        ->and($user->active)->toBe(true)
        ->and($user->visits_per_day)->toBe(5);
});

test('can update a user', function () {
    $userData = [
        'name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password123',
        'cellphone' => '1234567890',
        'dni_type' => DniType::TI->value,
        'dni' => '12345678',
        'active' => true,
        'visits_per_day' => 5,
    ];

    $user = User::create($userData);

    $user->update([
        'name' => 'Mary',
        'last_name' => 'Mac',
        'email' => 'mary.mac@example.com',
        'cellphone' => '9876543210',
        'dni_type' => DniType::CC->value,
        'dni' => '123456789',
        'active' => false,
        'visits_per_day' => 8,
    ]);

    expect($user->name)->toBe('Mary')
        ->and($user->last_name)->toBe('Mac')
        ->and($user->email)->toBe('mary.mac@example.com')
        ->and($user->cellphone)->toBe('9876543210')
        ->and($user->dni_type)->toBe(DniType::CC)
        ->and($user->dni)->toBe('123456789')
        ->and($user->active)->toBe(false)
        ->and($user->visits_per_day)->toBe(8);
});

test('can delete a user', function () {
    $user = User::factory()->create();

    $user->delete();

    expect(User::find($user->id))->toBeNull();
});

test('password is hashed when set', function () {
    $plainPassword = 'password123';
    $user = User::factory()->create(['password' => $plainPassword]);

    expect($user->password)->not->toBe($plainPassword);
    expect(Hash::check($plainPassword, $user->password))->toBeTrue();
});

test('can create user with only required fields', function () {
    $requiredData = [
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'password' => 'password123',
    ];

    $user = User::create($requiredData);

    expect($user->exists)->toBeTrue()
        ->and($user->name)->toBe('Jane')
        ->and($user->email)->toBe('jane@example.com');
});

test('email must be unique', function () {
    $email = 'unique@example.com';

    User::factory()->create(['email' => $email]);

    expect(fn() => User::factory()->create(['email' => $email]))
        ->toThrow(Exception::class);
});

test('can filter by active status', function () {

    User::factory()->count(3)->create(['active' => true]);
    User::factory()->count(2)->create(['active' => false]);

    expect(User::active()->count())->toBe(3);
});
