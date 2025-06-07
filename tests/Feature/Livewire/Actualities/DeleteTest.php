<?php

use App\Livewire\Actualities\Delete;
use App\Models\Actuality;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['actuality' => $actuality])
        ->assertStatus(200);
});

test('it mounts with actuality data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['actuality' => $actuality])
        ->assertSet('actuality.id', $actuality->id);
});

test('it can delete actuality', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['actuality' => $actuality])
        ->call('deleteActuality')
        ->assertDispatched('actualityDeleted');

    $actuality->refresh();

    expect($actuality->trashed())->toBeTrue();
});
