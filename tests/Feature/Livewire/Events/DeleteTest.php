<?php

use App\Livewire\Events\Delete;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['event' => $event])
        ->assertStatus(200);
});

test('it mounts with event data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['event' => $event])
        ->assertSet('event.id', $event->id);
});

test('it can delete event', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['event' => $event])
        ->call('deleteEvent')
        ->assertDispatched('eventDeleted');

    $event->refresh();

    expect($event->trashed())->toBeTrue();
});
