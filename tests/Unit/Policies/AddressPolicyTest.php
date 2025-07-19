<?php

use App\Models\Address;
use App\Models\Organization;
use App\Models\User;
use App\Policies\AddressPolicy;

it('allows super-admin to view any address', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $policy = new AddressPolicy();

    expect($policy->viewAny($user))->toBeTrue();
});

it('does not allow non-super-admin to view any address', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $policy = new AddressPolicy();

    expect($policy->viewAny($user))->toBeFalse();
});

it('allows super-admin to view an address', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $address = Address::factory()->create();
    $policy = new AddressPolicy();

    expect($policy->view($user, $address))->toBeTrue();
});

it('allows user from same organization to view an address', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization;

    $policy = new AddressPolicy();

    expect($policy->view($user, $address))->toBeTrue();
});

it('does not allow user from different organization to view an address', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization1->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization2->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization2;

    $policy = new AddressPolicy();

    expect($policy->view($user, $address))->toBeFalse();
});

it('allows super-admin to create an address', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $policy = new AddressPolicy();

    expect($policy->create($user))->toBeTrue();
});

it('allows admin to create an address', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $policy = new AddressPolicy();

    expect($policy->create($user))->toBeTrue();
});

it('does not allow regular user to create an address', function () {
    $user = User::factory()->create(['role' => 'user']);
    $policy = new AddressPolicy();

    expect($policy->create($user))->toBeFalse();
});

it('allows super-admin to update an address', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $address = Address::factory()->create();
    $policy = new AddressPolicy();

    expect($policy->update($user, $address))->toBeTrue();
});

it('allows user from same organization to update an address', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization;

    $policy = new AddressPolicy();

    expect($policy->update($user, $address))->toBeTrue();
});

it('does not allow user from different organization to update an address', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization1->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization2->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization2;

    $policy = new AddressPolicy();

    expect($policy->update($user, $address))->toBeFalse();
});

it('allows super-admin to delete an address', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $address = Address::factory()->create();
    $policy = new AddressPolicy();

    expect($policy->delete($user, $address))->toBeTrue();
});

it('allows user from same organization to delete an address', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization;

    $policy = new AddressPolicy();

    expect($policy->delete($user, $address))->toBeTrue();
});

it('does not allow user from different organization to delete an address', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization1->id
    ]);
    $address = Address::factory()->create(['organization_id' => $organization2->id]);

    // Mock the organization relationship on the address
    $address->organization = $organization2;

    $policy = new AddressPolicy();

    expect($policy->delete($user, $address))->toBeFalse();
});

it('allows only super-admin to restore an address', function () {
    $superAdmin = User::factory()->create(['role' => 'super-admin']);
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $policy = new AddressPolicy();

    expect($policy->restore($superAdmin))->toBeTrue()
        ->and($policy->restore($admin))->toBeFalse()
        ->and($policy->restore($user))->toBeFalse();
});

it('allows only super-admin to force delete an address', function () {
    $superAdmin = User::factory()->create(['role' => 'super-admin']);
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $policy = new AddressPolicy();

    expect($policy->forceDelete($superAdmin))->toBeTrue()
        ->and($policy->forceDelete($admin))->toBeFalse()
        ->and($policy->forceDelete($user))->toBeFalse();
});
