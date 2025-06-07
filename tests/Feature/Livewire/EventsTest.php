<?php

use App\Livewire\Events;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Events::class)
        ->assertStatus(200);
});

test('it displays events for current organization', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create events for this organization
    $events = Event::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    // Create events for another organization
    $otherOrganization = Organization::factory()->create();
    Event::factory()->count(2)->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Events::class)
        ->assertViewHas('events', function ($viewEvents) use ($organization) {
            return $viewEvents->count() === 3 &&
                $viewEvents->pluck('organization_id')->unique()->first() === $organization->id;
        });
});

test('it can sort events', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create events with different dates
    Event::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Older Event',
        'start_date' => now()->subDays(2),
    ]);

    Event::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Newer Event',
        'start_date' => now(),
    ]);

    $this->actingAs($user);

    // Test default sorting (start_date desc)
    Livewire::test(Events::class)
        ->assertSet('sortField', 'start_date')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'title')
        ->assertSet('sortDirection', 'desc');
});

test('it can search events', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create events with different titles, descriptions, and locations
    Event::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Laravel Conference',
        'description' => 'A conference about Laravel',
        'location' => 'Paris',
    ]);

    Event::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'PHP Workshop',
        'description' => 'A workshop about PHP',
        'location' => 'London',
    ]);

    $this->actingAs($user);

    // Test search by title
    Livewire::test(Events::class)
        ->set('search', 'Laravel')
        ->assertViewHas('events', function ($viewEvents) {
            return $viewEvents->count() === 1 &&
                $viewEvents->first()->title === 'Laravel Conference';
        });

    // Test search by description
    Livewire::test(Events::class)
        ->set('search', 'workshop')
        ->assertViewHas('events', function ($viewEvents) {
            return $viewEvents->count() === 1 &&
                $viewEvents->first()->title === 'PHP Workshop';
        });

    // Test search by location
    Livewire::test(Events::class)
        ->set('search', 'London')
        ->assertViewHas('events', function ($viewEvents) {
            return $viewEvents->count() === 1 &&
                $viewEvents->first()->location === 'London';
        });
});

test('it responds to event events', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Events::class)
        ->call('eventCreated')
        ->assertDispatched('refresh')
        ->call('eventEdited')
        ->assertDispatched('refresh')
        ->call('eventDeleted')
        ->assertDispatched('refresh');
});

test('it sets canDelete based on user role', function () {
    // Regular user
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Events::class)
        ->assertSet('canDelete', false);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    Livewire::test(Events::class)
        ->assertSet('canDelete', true);

    // Super admin
    $superAdmin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Events::class)
        ->assertSet('canDelete', true);
});
