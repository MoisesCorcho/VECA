<?php

use App\Enums\DniType;
use App\Models\Member;
use App\Models\Address;
use App\Models\Organization;
use App\Models\MemberPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

uses(RefreshDatabase::class);

test('can create member using factory', function () {
    $member = Member::factory()->create();

    expect($member)->toBeInstanceOf(Member::class)
        ->and($member->id)->toBeUuid();
});

test('member has correct fillable attributes', function () {
    $member = new Member();

    expect($member->getFillable())->toEqual([
        'first_name',
        'last_name',
        'dni_type',
        'dni',
        'cellphone_1',
        'cellphone_2',
        'phone',
        'birthdate',
        'email',
        'organization_id',
        'member_position_id',
    ]);
});

test('member belongs to an organization', function () {
    $member = new Member();

    expect($member->organization())->toBeInstanceOf(BelongsTo::class);

    $member = Member::factory()
        ->for(Organization::factory())
        ->create();

    expect($member->organization)->toBeInstanceOf(Organization::class);
});

test('member belongs to a position', function () {
    $member = new Member();

    expect($member->memberPosition())->toBeInstanceOf(BelongsTo::class);

    $member = Member::factory()
        ->for(MemberPosition::factory(), 'memberPosition')
        ->create();

    expect($member->memberPosition)->toBeInstanceOf(MemberPosition::class);
});

test('can create a member', function () {
    $organization = Organization::factory()->create();
    $position = MemberPosition::factory()->create();

    $memberData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'dni_type' => DniType::CC->value,
        'dni' => '12345678',
        'cellphone_1' => '123456789',
        'cellphone_2' => '987654321',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'birthdate' => '1990-01-01',
        'organization_id' => $organization->id,
        'member_position_id' => $position->id,
    ];

    $member = Member::create($memberData);

    $this->assertDatabaseHas('members', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'dni' => '12345678',
    ]);

    expect($member->first_name)->toBe('John')
        ->and($member->last_name)->toBe('Doe')
        ->and($member->dni_type)->toBe(DniType::CC->value)
        ->and($member->dni)->toBe('12345678')
        ->and($member->cellphone_1)->toBe('123456789')
        ->and($member->cellphone_2)->toBe('987654321')
        ->and($member->email)->toBe('john@example.com')
        ->and($member->phone)->toBe('+1234567890')
        ->and($member->birthdate)->toBe('1990-01-01')
        ->and($member->organization_id)->toBe($organization->id)
        ->and($member->member_position_id)->toBe($position->id);
});

test('can update a member', function () {
    $member = Member::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    $member->update([
        'first_name' => 'Jane',
        'last_name' => 'Smith',
    ]);

    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'first_name' => 'Jane',
        'last_name' => 'Smith',
    ]);
});

test('can delete a member', function () {
    $member = Member::factory()->create();

    $member->delete();

    $this->assertDatabaseMissing('members', [
        'id' => $member->id,
    ]);
});

test('can create member for specific organization and position', function () {
    $organization = Organization::factory()->create();
    $position = MemberPosition::factory()->create();

    $member = Member::factory()->create([
        'organization_id' => $organization->id,
        'member_position_id' => $position->id,
    ]);

    expect($member->organization_id)->toBe($organization->id)
        ->and($member->memberPosition->id)->toBe($position->id);
});

test('member requires a first name', function () {
    expect(function () {
        Member::factory()->create(['first_name' => null]);
    })->toThrow(Exception::class);
});

test('member requires a last name', function () {
    expect(function () {
        Member::factory()->create(['last_name' => null]);
    })->toThrow(Exception::class);
});

test('member dni must be unique', function () {
    $member1 = Member::factory()->create(['dni' => '12345678']);

    expect(function () use ($member1) {
        Member::factory()->create(['dni' => $member1->dni]);
    })->toThrow(Exception::class);
});

test('member can have an address associated', function () {
    $member = Member::factory()->create();

    $member->addresses()->create([
        'street' => '123 Main St',
        'city' => 'Anytown',
        'state' => 'CA',
        'country' => 'USA',
        'zip_code' => '12345',
    ]);

    expect($member->addresses->first())->toBeInstanceOf(Address::class)
        ->and($member->addresses->first()->street)->toBe('123 Main St')
        ->and($member->addresses->first()->city)->toBe('Anytown')
        ->and($member->addresses->first()->state)->toBe('CA')
        ->and($member->addresses->first()->country)->toBe('USA')
        ->and($member->addresses->first()->zip_code)->toBe('12345');
});
