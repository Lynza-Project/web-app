<?php

use App\Helpers\UserHelper;
use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;
use Mockery;

beforeEach(function () {
    // Mock the UserHelper methods
    $this->mock = Mockery::mock('alias:' . UserHelper::class);
    $this->mock->shouldReceive('isAdministrator')->andReturn(true)->byDefault();
    $this->mock->shouldReceive('isSuperAdministrator')->andReturn(false)->byDefault();
});

test('guests cannot access documentation pages', function () {
    $documentation = Documentation::factory()->create();

    $this->get(route('documentations.index'))->assertRedirect('/login');
    $this->get(route('documentations.show', $documentation))->assertRedirect('/login');
    $this->get(route('documentations.edit', $documentation))->assertRedirect('/login');
});

test('users can view documentation index', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user)
        ->get(route('documentations.index'))
        ->assertStatus(200)
        ->assertViewIs('documentations.index');
});

test('users can view documentation from their organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user)
        ->get(route('documentations.show', $documentation))
        ->assertStatus(200)
        ->assertViewIs('documentations.show')
        ->assertViewHas('documentation', $documentation);
});

test('users cannot view documentation from other organizations', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $otherOrganization = Organization::factory()->create();
    $documentation = Documentation::factory()->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user)
        ->get(route('documentations.show', $documentation))
        ->assertStatus(403);
});

test('super admin can view any documentation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $otherOrganization = Organization::factory()->create();
    $documentation = Documentation::factory()->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user)
        ->get(route('documentations.show', $documentation))
        ->assertStatus(200)
        ->assertViewIs('documentations.show')
        ->assertViewHas('documentation', $documentation);
});

test('only admins can edit documentation', function () {
    $organization = Organization::factory()->create();

    // Regular user
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'user',
    ]);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Regular user cannot access edit page
    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->get(route('documentations.edit', $documentation))
        ->assertStatus(403);

    // Admin can access edit page
    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($admin)
        ->get(route('documentations.edit', $documentation))
        ->assertStatus(200)
        ->assertViewIs('documentations.edit')
        ->assertViewHas('documentation', $documentation);
});

test('only admins can update documentation', function () {
    $organization = Organization::factory()->create();

    // Regular user
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'user',
    ]);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Regular user cannot update
    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->put(route('documentations.update', $documentation))
        ->assertStatus(403);

    // Admin can update
    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($admin)
        ->put(route('documentations.update', $documentation))
        ->assertRedirect(route('documentations.show', $documentation))
        ->assertSessionHas('success');
});

test('only admins can delete documentation', function () {
    $organization = Organization::factory()->create();

    // Regular user
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'user',
    ]);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Regular user cannot delete
    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->delete(route('documentations.destroy', $documentation))
        ->assertStatus(403);

    // Admin can delete
    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($admin)
        ->delete(route('documentations.destroy', $documentation))
        ->assertRedirect(route('documentations.index'))
        ->assertSessionHas('success');
});

test('admins cannot edit documentation from other organizations', function () {
    $admin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $otherOrganization = Organization::factory()->create();
    $documentation = Documentation::factory()->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($admin)
        ->get(route('documentations.edit', $documentation))
        ->assertStatus(403);
});

test('super admin can edit any documentation', function () {
    $superAdmin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $otherOrganization = Organization::factory()->create();
    $documentation = Documentation::factory()->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('documentations.edit', $documentation))
        ->assertStatus(200)
        ->assertViewIs('documentations.edit')
        ->assertViewHas('documentation', $documentation);
});
