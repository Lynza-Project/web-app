<?php

use App\Livewire\Themes;
use App\Models\Theme;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Themes::class)
        ->assertStatus(200);
});

test('it displays themes for current organization', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create themes for this organization
    $themes = Theme::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    // Create themes for another organization
    $otherOrganization = Organization::factory()->create();
    Theme::factory()->count(2)->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Themes::class)
        ->assertViewHas('themes', function ($viewThemes) use ($organization) {
            return $viewThemes->count() === 3 &&
                $viewThemes->pluck('organization_id')->unique()->first() === $organization->id;
        });
});

test('it can sort themes', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create themes with different titles
    Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Z Theme',
        'created_at' => now()->subDay(),
    ]);

    Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'A Theme',
        'created_at' => now(),
    ]);

    $this->actingAs($user);

    // Test default sorting (created_at desc)
    Livewire::test(Themes::class)
        ->assertSet('sortField', 'created_at')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'title')
        ->assertSet('sortDirection', 'desc');
});

test('it can search themes', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create themes with different titles and primary colors
    Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Blue Theme',
        'primary' => 'blue-500',
    ]);

    Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Red Theme',
        'primary' => 'red-500',
    ]);

    $this->actingAs($user);

    // Test search by title
    Livewire::test(Themes::class)
        ->set('search', 'Blue')
        ->assertViewHas('themes', function ($viewThemes) {
            return $viewThemes->count() === 1 &&
                $viewThemes->first()->title === 'Blue Theme';
        });

    // Test search by primary color
    Livewire::test(Themes::class)
        ->set('search', 'red')
        ->assertViewHas('themes', function ($viewThemes) {
            return $viewThemes->count() === 1 &&
                $viewThemes->first()->primary === 'red-500';
        });
});

test('it responds to theme events', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Themes::class)
        ->call('themeCreated')
        ->assertDispatched('refresh')
        ->call('themeEdited')
        ->assertDispatched('refresh')
        ->call('themeDeleted')
        ->assertDispatched('refresh');
});

test('it sets canManage based on user role', function () {
    // Regular user
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Themes::class)
        ->assertSet('canManage', false);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    Livewire::test(Themes::class)
        ->assertSet('canManage', true);

    // Super admin
    $superAdmin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Themes::class)
        ->assertSet('canManage', true);
});

test('it handles searchUpdated event with array parameter', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Themes::class)
        ->assertSet('search', '')
        ->dispatch('searchUpdated', ['test search'])
        ->assertSet('search', 'test search');
});
