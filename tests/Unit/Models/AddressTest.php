<?php

use App\Models\Address;
use App\Models\Organization;

it('has fillable attributes', function () {
    $address = new Address();

    expect($address->getFillable())->toEqual([
        'organization_id',
        'number',
        'name',
        'zip_code',
        'country',
        'region',
    ]);
});

it('belongs to an organization', function () {
    $address = Address::factory()->create();

    expect($address->organization)->toBeInstanceOf(Organization::class);
});

it('uses soft deletes', function () {
    $address = Address::factory()->create();

    $address->delete();

    expect(Address::find($address->id))->toBeNull();
    expect(Address::withTrashed()->find($address->id))->toBeInstanceOf(Address::class);
});

it('can be created with valid attributes', function () {
    $organization = Organization::factory()->create();

    $address = Address::create([
        'organization_id' => $organization->id,
        'number' => '123',
        'name' => 'Main Street',
        'zip_code' => '12345',
        'country' => 'USA',
        'region' => 'California',
    ]);

    expect($address)->toBeInstanceOf(Address::class)
        ->and($address->organization_id)->toBe($organization->id)
        ->and($address->number)->toBe('123')
        ->and($address->name)->toBe('Main Street')
        ->and($address->zip_code)->toBe('12345')
        ->and($address->country)->toBe('USA')
        ->and($address->region)->toBe('California');
});
