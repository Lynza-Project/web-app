<?php

use App\Helpers\UserHelper;
use App\Models\Actuality;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Mock the UserHelper methods
    $this->mock = Mockery::mock('alias:' . UserHelper::class);
    $this->mock->shouldReceive('isAdministrator')->andReturn(true)->byDefault();
    $this->mock->shouldReceive('isSuperAdministrator')->andReturn(false)->byDefault();
});

it('displays the index page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('actualities.index'))
        ->assertStatus(200)
        ->assertViewIs('actualities.index');
});

it('displays the show page for an actuality when user has access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create(['organization_id' => $actuality->organization_id]);

    $this->actingAs($user)
        ->get(route('actualities.show', $actuality))
        ->assertStatus(200)
        ->assertViewIs('actualities.show')
        ->assertViewHas('actuality', $actuality);
});

it('forbids access to show page for an actuality when user does not have access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create(); // Different organization

    $this->actingAs($user)
        ->get(route('actualities.show', $actuality))
        ->assertStatus(403);
});

it('displays the edit page for an actuality when user is an administrator and has access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->get(route('actualities.edit', $actuality))
        ->assertStatus(200)
        ->assertViewIs('actualities.edit')
        ->assertViewHas('actuality', $actuality);
});

it('forbids access to edit page for an actuality when user is not an administrator', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->get(route('actualities.edit', $actuality))
        ->assertStatus(403);
});

it('forbids access to edit page for an actuality when user does not have access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin'
    ]); // Different organization

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->get(route('actualities.edit', $actuality))
        ->assertStatus(403);
});

it('updates an actuality when user is an administrator and has access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->put(route('actualities.update', $actuality))
        ->assertRedirect(route('actualities.show', $actuality))
        ->assertSessionHas('success', 'Actualité mise à jour avec succès.');
});

it('forbids updating an actuality when user is not an administrator', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->put(route('actualities.update', $actuality))
        ->assertStatus(403);
});

it('forbids updating an actuality when user does not have access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin'
    ]); // Different organization

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->put(route('actualities.update', $actuality))
        ->assertStatus(403);
});

it('deletes an actuality when user is an administrator and has access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin',
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->delete(route('actualities.destroy', $actuality))
        ->assertRedirect(route('actualities.index'))
        ->assertSessionHas('success', 'Actualité supprimée avec succès.');

    $this->assertSoftDeleted($actuality);
});

it('forbids deleting an actuality when user is not an administrator', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $actuality->organization_id
    ]);

    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->delete(route('actualities.destroy', $actuality))
        ->assertStatus(403);

    $this->assertDatabaseHas('actualities', ['id' => $actuality->id]);
});

it('forbids deleting an actuality when user does not have access', function () {
    $actuality = Actuality::factory()->create();
    $user = User::factory()->create([
        'role' => 'admin'
    ]); // Different organization

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->delete(route('actualities.destroy', $actuality))
        ->assertStatus(403);

    $this->assertDatabaseHas('actualities', ['id' => $actuality->id]);
});
