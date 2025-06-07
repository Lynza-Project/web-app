<?php

use App\Livewire\Users\Update;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->assertStatus(200);
});

test('it mounts with user data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Original First',
        'last_name' => 'Original Last',
        'email' => 'original@example.com',
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->assertSet('first_name', 'Original First')
        ->assertSet('last_name', 'Original Last')
        ->assertSet('email', 'original@example.com')
        ->assertSet('role', 'user');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->set('first_name', '')
        ->set('last_name', '')
        ->set('email', '')
        ->set('role', '')
        ->call('submit')
        ->assertHasErrors(['first_name', 'last_name', 'email', 'role']);
});

test('it validates email format', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'invalid-email')
        ->set('role', 'user')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('it can update a user', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Original First',
        'last_name' => 'Original Last',
        'email' => 'original@example.com',
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->set('first_name', 'Updated First')
        ->set('last_name', 'Updated Last')
        ->set('email', 'updated@example.com')
        ->set('role', 'admin')
        ->call('submit')
        ->assertDispatched('userUpdated');

    expect(User::find($userToUpdate->id))->toMatchArray([
        'first_name' => 'Updated First',
        'last_name' => 'Updated Last',
        'email' => 'updated@example.com',
        'role' => 'admin',
    ]);
});

test('it allows updating without changing email', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToUpdate = User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Original First',
        'last_name' => 'Original Last',
        'email' => 'original@example.com',
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Update::class, ['user' => $userToUpdate])
        ->set('first_name', 'Updated First')
        ->set('last_name', 'Updated Last')
        ->set('email', 'original@example.com') // Same email
        ->set('role', 'admin')
        ->call('submit')
        ->assertDispatched('userUpdated');

    expect(User::find($userToUpdate->id))->toMatchArray([
        'first_name' => 'Updated First',
        'last_name' => 'Updated Last',
        'email' => 'original@example.com',
        'role' => 'admin',
    ]);
});
