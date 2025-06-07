<?php

use App\Livewire\Documentations\Delete;
use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['documentation' => $documentation])
        ->assertStatus(200);
});

test('it mounts with documentation data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['documentation' => $documentation])
        ->assertSet('documentation.id', $documentation->id);
});

test('it can delete documentation', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['documentation' => $documentation])
        ->call('deleteDocumentation')
        ->assertDispatched('documentationDeleted');

    $documentation->refresh();

    expect($documentation->trashed())->toBeTrue();
});
