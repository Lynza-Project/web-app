<?php

use App\Livewire\Actualities;
use App\Models\Actuality;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Actualities::class)
        ->assertStatus(200);
});

test('it displays actualities for current organization', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create actualities for this organization
    $actualities = Actuality::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    // Create actualities for another organization
    $otherOrganization = Organization::factory()->create();
    Actuality::factory()->count(2)->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Actualities::class)
        ->assertViewHas('actualities', function ($viewActualities) use ($organization) {
            return $viewActualities->count() === 3 &&
                $viewActualities->pluck('organization_id')->unique()->first() === $organization->id;
        });
});

test('it can sort actualities', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create actualities with different titles
    Actuality::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Z Actuality',
        'created_at' => now()->subDay(),
    ]);

    Actuality::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'A Actuality',
        'created_at' => now(),
    ]);

    $this->actingAs($user);

    // Test default sorting (created_at desc)
    Livewire::test(Actualities::class)
        ->assertSet('sortField', 'created_at')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'title')
        ->assertSet('sortDirection', 'desc');
});

test('it can search actualities', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create actualities with different titles and content
    Actuality::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Laravel Actuality',
        'content' => 'Content about Laravel',
    ]);

    Actuality::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'PHP Actuality',
        'content' => 'Content about PHP',
    ]);

    $this->actingAs($user);

    // Test search by title
    Livewire::test(Actualities::class)
        ->set('search', 'Laravel')
        ->assertViewHas('actualities', function ($viewActualities) {
            return $viewActualities->count() === 1 &&
                $viewActualities->first()->title === 'Laravel Actuality';
        });

    // Test search by content
    Livewire::test(Actualities::class)
        ->set('search', 'PHP')
        ->assertViewHas('actualities', function ($viewActualities) {
            return $viewActualities->count() === 1 &&
                $viewActualities->first()->title === 'PHP Actuality';
        });
});

test('it responds to actuality events', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Actualities::class)
        ->call('actualityCreated')
        ->assertDispatched('refresh')
        ->call('actualityEdited')
        ->assertDispatched('refresh')
        ->call('actualityDeleted')
        ->assertDispatched('refresh');
});

test('it sets canDelete based on user role', function () {
    // Regular user
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Actualities::class)
        ->assertSet('canDelete', false);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    Livewire::test(Actualities::class)
        ->assertSet('canDelete', true);

    // Super admin
    $superAdmin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Actualities::class)
        ->assertSet('canDelete', true);
});

test('it handles searchUpdated event with array parameter', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Actualities::class)
        ->assertSet('search', '')
        ->dispatch('searchUpdated', ['test search'])
        ->assertSet('search', 'test search');
});
