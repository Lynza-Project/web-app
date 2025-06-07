<?php

use App\Livewire\Users\Delete;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToDelete = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['user' => $userToDelete])
        ->assertStatus(200);
});

test('it mounts with user data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToDelete = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['user' => $userToDelete])
        ->assertSet('user.id', $userToDelete->id);
});

test('it can delete a user', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToDelete = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['user' => $userToDelete])
        ->call('deleteUser')
        ->assertDispatched('userDeleted');

    $userToDelete->refresh();

    expect($userToDelete->trashed())->toBeTrue();
});
