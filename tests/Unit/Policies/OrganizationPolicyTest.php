<?php

use App\Models\Organization;
use App\Models\User;
use App\Policies\OrganizationPolicy;

it('allows anyone to view any organization', function () {
    $policy = new OrganizationPolicy();

    expect($policy->viewAny())->toBeTrue();
});

it('allows user to view their own organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create(['organization_id' => $organization->id]);
    $policy = new OrganizationPolicy();

    expect($policy->view($user, $organization))->toBeTrue();
});

it('does not allow user to view other organizations', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create(['organization_id' => $organization1->id]);
    $policy = new OrganizationPolicy();

    expect($policy->view($user, $organization2))->toBeFalse();
});

it('allows admin to create an organization', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $policy = new OrganizationPolicy();

    expect($policy->create($user))->toBeTrue();
});

it('allows super-admin to create an organization', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $policy = new OrganizationPolicy();

    expect($policy->create($user))->toBeTrue();
});

it('does not allow regular user to create an organization', function () {
    $user = User::factory()->create(['role' => 'user']);
    $policy = new OrganizationPolicy();

    expect($policy->create($user))->toBeFalse();
});

it('allows super-admin to update any organization', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $organization = Organization::factory()->create();
    $policy = new OrganizationPolicy();

    expect($policy->update($user, $organization))->toBeTrue();
});

it('allows admin to update their own organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $organization->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->update($user, $organization))->toBeTrue();
});

it('does not allow admin to update other organizations', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $organization1->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->update($user, $organization2))->toBeFalse();
});

it('does not allow regular user to update any organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->update($user, $organization))->toBeFalse();
});

it('allows super-admin to delete any organization', function () {
    $user = User::factory()->create(['role' => 'super-admin']);
    $organization = Organization::factory()->create();
    $policy = new OrganizationPolicy();

    expect($policy->delete($user, $organization))->toBeTrue();
});

it('allows admin to delete their own organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $organization->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->delete($user, $organization))->toBeTrue();
});

it('does not allow admin to delete other organizations', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $organization1->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->delete($user, $organization2))->toBeFalse();
});

it('does not allow regular user to delete any organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'role' => 'user',
        'organization_id' => $organization->id
    ]);
    $policy = new OrganizationPolicy();

    expect($policy->delete($user, $organization))->toBeFalse();
});

it('allows only super-admin to restore an organization', function () {
    $superAdmin = User::factory()->create(['role' => 'super-admin']);
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $policy = new OrganizationPolicy();

    expect($policy->restore($superAdmin))->toBeTrue()
        ->and($policy->restore($admin))->toBeFalse()
        ->and($policy->restore($user))->toBeFalse();
});

it('allows only super-admin to force delete an organization', function () {
    $superAdmin = User::factory()->create(['role' => 'super-admin']);
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $policy = new OrganizationPolicy();

    expect($policy->forceDelete($superAdmin))->toBeTrue()
        ->and($policy->forceDelete($admin))->toBeFalse()
        ->and($policy->forceDelete($user))->toBeFalse();
});
