<?php

use App\Models\Member;
use App\Models\MemberPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('member position factory creates valid member positions', function () {
    $memberPosition = MemberPosition::factory()->create();

    expect($memberPosition)->toBeInstanceOf(MemberPosition::class)
        ->and($memberPosition->id)->toBeInt();
});

test('member position has correct fillable attributes', function () {
    $memberPosition = new MemberPosition();

    expect($memberPosition->getFillable())->toEqual([
        'name',
        'description',
    ]);
});

test('can create a member position', function () {
    $memberPosition = MemberPosition::create([
        'name' => 'Test Position',
        'description' => 'This is a test position.',
    ]);

    expect($memberPosition)->toBeInstanceOf(MemberPosition::class)
        ->and($memberPosition->name)->toEqual('Test Position')
        ->and($memberPosition->description)->toEqual('This is a test position.');
});

test('can update a member position', function () {
    $memberPosition = MemberPosition::create([
        'name' => 'Test Position',
        'description' => 'This is a test position.',
    ]);

    $memberPosition->update([
        'name' => 'Updated Position',
        'description' => 'This is an updated test position.',
    ]);

    expect($memberPosition)->toBeInstanceOf(MemberPosition::class)
        ->and($memberPosition->name)->toEqual('Updated Position')
        ->and($memberPosition->description)->toEqual('This is an updated test position.');
});

test('can delete a member position', function () {
    $memberPosition = MemberPosition::create([
        'name' => 'Test Position',
        'description' => 'This is a test position.',
    ]);

    $memberPosition->delete();

    expect(MemberPosition::find($memberPosition->id))->toBeNull();

    $this->assertDatabaseMissing('member_positions', [
        'id' => $memberPosition->id,
    ]);
});

test('a member position can have members associated', function () {
    $memberPosition = MemberPosition::create([
        'name' => 'Test Position',
        'description' => 'This is a test position.',
    ]);

    Member::factory()->count(3)->create([
        'member_position_id' => $memberPosition->id,
    ]);

    expect($memberPosition->members->count())->toBe(3);
});
