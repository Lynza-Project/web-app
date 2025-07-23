<?php

use App\Models\Organization;
use App\Models\Address;
use App\Models\Theme;

it('has fillable attributes', function () {
    $organization = new Organization();

    expect($organization->getFillable())->toEqual([
        'name',
        'type',
        'logo',
    ]);
});

it('has many addresses', function () {
    $organization = Organization::factory()->create();
    $address = Address::factory()->create(['organization_id' => $organization->id]);

    expect($organization->addresses)->toBeCollection()
        ->and($organization->addresses->first())->toBeInstanceOf(Address::class);
});

it('has many themes', function () {
    $organization = Organization::factory()->create();
    $theme = Theme::factory()->create(['organization_id' => $organization->id]);

    expect($organization->themes)->toBeCollection()
        ->and($organization->themes->first())->toBeInstanceOf(Theme::class);
});

it('uses soft deletes', function () {
    $organization = Organization::factory()->create();

    $organization->delete();

    expect(Organization::find($organization->id))->toBeNull();
    expect(Organization::withTrashed()->find($organization->id))->toBeInstanceOf(Organization::class);
});

it('can be created with valid attributes', function () {
    $organization = Organization::create([
        'name' => 'Test Organization',
        'type' => 'company',
        'logo' => 'logo.png',
    ]);

    expect($organization)->toBeInstanceOf(Organization::class)
        ->and($organization->name)->toBe('Test Organization')
        ->and($organization->type)->toBe('company')
        ->and($organization->logo)->toBe('logo.png');
});

it('cascades delete to related addresses', function () {
    $organization = Organization::factory()->create();
    $address = Address::factory()->create(['organization_id' => $organization->id]);

    $organization->delete();

    // The address should still exist but be soft deleted
    expect(Address::find($address->id))->toBeNull();
    expect(Address::withTrashed()->find($address->id))->toBeInstanceOf(Address::class);
});
