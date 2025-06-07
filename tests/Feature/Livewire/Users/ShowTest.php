<?php

use App\Livewire\Users\Show;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToShow = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Show::class, ['user' => $userToShow])
        ->assertStatus(200);
});

test('it mounts with user data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $userToShow = User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Show::class, ['user' => $userToShow])
        ->assertSet('user.id', $userToShow->id)
        ->assertSet('user.first_name', 'John')
        ->assertSet('user.last_name', 'Doe')
        ->assertSet('user.email', 'john.doe@example.com')
        ->assertSet('user.role', 'user');
});
