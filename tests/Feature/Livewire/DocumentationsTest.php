<?php

use App\Livewire\Documentations;
use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Documentations::class)
        ->assertStatus(200);
});

test('it displays documentations for current organization', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create documentations for this organization
    $documentations = Documentation::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    // Create documentations for another organization
    $otherOrganization = Organization::factory()->create();
    Documentation::factory()->count(2)->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Documentations::class)
        ->assertViewHas('documentations', function ($viewDocumentations) use ($organization) {
            return $viewDocumentations->count() === 3 &&
                $viewDocumentations->pluck('organization_id')->unique()->first() === $organization->id;
        });
});

test('it can sort documentations', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create documentations with different titles
    Documentation::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Z Documentation',
        'created_at' => now()->subDay(),
    ]);

    Documentation::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'A Documentation',
        'created_at' => now(),
    ]);

    $this->actingAs($user);

    // Test default sorting (created_at desc)
    Livewire::test(Documentations::class)
        ->assertSet('sortField', 'created_at')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'title')
        ->assertSet('sortDirection', 'desc');
});

test('it can search documentations', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create documentations with different titles
    Documentation::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Laravel Documentation',
        'content' => 'Content about Laravel',
    ]);

    Documentation::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'PHP Documentation',
        'content' => 'Content about PHP',
    ]);

    $this->actingAs($user);

    // Test search by title
    Livewire::test(Documentations::class)
        ->set('search', 'Laravel')
        ->assertViewHas('documentations', function ($viewDocumentations) {
            return $viewDocumentations->count() === 1 &&
                $viewDocumentations->first()->title === 'Laravel Documentation';
        });

    // Test search by content
    Livewire::test(Documentations::class)
        ->set('search', 'PHP')
        ->assertViewHas('documentations', function ($viewDocumentations) {
            return $viewDocumentations->count() === 1 &&
                $viewDocumentations->first()->title === 'PHP Documentation';
        });
});

test('it responds to documentation events', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Documentations::class)
        ->call('documentationCreated')
        ->assertDispatched('refresh')
        ->call('documentationEdited')
        ->assertDispatched('refresh')
        ->call('documentationDeleted')
        ->assertDispatched('refresh');
});
