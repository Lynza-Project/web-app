<?php

use App\Helpers\UserHelper;
use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;

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
