<?php

use App\Models\Address;
use App\Models\Organization;
use App\Models\User;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('validates address data correctly', function () {
    $service = app(AddressService::class);

    $validData = [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
        'zip_code' => '12345',
    ];

    $validatedData = $service->validateAddressData($validData);

    expect($validatedData)->toBe($validData);
});

test('throws exception for invalid address data', function () {
    $service = app(AddressService::class);

    $invalidData = [
        'street' => '',
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class);
});

test('saves new address to entity', function () {

    $organization = Organization::factory()->create();

    $addressData = [
        'street' => '123 Corp St',
        'city' => 'Business City',
        'state' => 'Commerce State',
        'country' => 'Corporateland',
        'zip_code' => '54321',
    ];

    $service = app(AddressService::class);
    $address = $service->saveAddress($organization, $addressData);

    expect($address)->toBeInstanceOf(Address::class)
        ->and($address->street)->toBe('123 Corp St')
        ->and($address->city)->toBe('Business City')
        ->and($address->state)->toBe('Commerce State')
        ->and($address->country)->toBe('Corporateland')
        ->and($address->zip_code)->toBe('54321');
});

test('updates existing address on entity', function () {
    $organization = Organization::factory()->create();

    $initialAddress = $organization->addresses()->create([
        'street' => 'Initial Street',
        'city' => 'Initial City',
        'state' => 'Initial State',
        'country' => 'Initial Country',
        'zip_code' => '00000',
    ]);

    $newAddressData = [
        'street' => 'Updated Street',
        'city' => 'Updated City',
        'state' => 'Updated State',
        'country' => 'Updated Country',
        'zip_code' => '99999',
    ];

    $service = app(AddressService::class);
    $updatedAddress = $service->saveAddress($organization, $newAddressData);

    expect($updatedAddress->id)->toBe($initialAddress->id)
        ->and($updatedAddress->street)->toBe('Updated Street')
        ->and($updatedAddress->city)->toBe('Updated City')
        ->and($updatedAddress->state)->toBe('Updated State')
        ->and($updatedAddress->country)->toBe('Updated Country')
        ->and($updatedAddress->zip_code)->toBe('99999');
});

test('throws exception for entity that does not support addresses', function () {

    $modelWithoutAddresses = new class extends \Illuminate\Database\Eloquent\Model {};

    $addressData = [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
        'zip_code' => '12345',
    ];

    $service = app(AddressService::class);

    expect(fn() => $service->saveAddress($modelWithoutAddresses, $addressData))
        ->toThrow(\InvalidArgumentException::class, 'The entity does not support addresses.');
});

test('validates street is required', function () {
    $service = app(AddressService::class);

    $invalidData = [
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
        'zip_code' => '12345',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class, 'street');
});

test('validates city is required', function () {
    $service = app(AddressService::class);

    $invalidData = [
        'street' => '123 Main St',
        'state' => 'IL',
        'country' => 'USA',
        'zip_code' => '12345',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class, 'city');
});

test('validates state is required', function () {
    $service = app(AddressService::class);

    $invalidData = [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'country' => 'USA',
        'zip_code' => '12345',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class, 'state');
});

test('validates country is required', function () {
    $service = app(AddressService::class);

    $invalidData = [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'zip_code' => '12345',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class, 'country');
});

test('zip code can be null', function () {
    $service = app(AddressService::class);

    $validData = [
        'street' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
    ];

    $validatedData = $service->validateAddressData($validData);

    expect($validatedData)->toBe($validData);
});

test('validates field max lengths', function () {
    $service = app(AddressService::class);

    $tooLongString = str_repeat('a', 300);

    $invalidData = [
        'street' => $tooLongString,
        'city' => 'Springfield',
        'state' => 'IL',
        'country' => 'USA',
    ];

    expect(fn() => $service->validateAddressData($invalidData))
        ->toThrow(\InvalidArgumentException::class);
});
