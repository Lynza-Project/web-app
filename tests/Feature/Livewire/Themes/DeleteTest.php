<?php

use App\Livewire\Themes\Delete;
use App\Models\Theme;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['theme' => $theme])
        ->assertStatus(200);
});

test('it mounts with theme data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['theme' => $theme])
        ->assertSet('theme.id', $theme->id);
});

test('it can delete theme', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Delete::class, ['theme' => $theme])
        ->call('deleteTheme')
        ->assertDispatched('themeDeleted');

    $this->assertDatabaseMissing('themes', [
        'id' => $theme->id,
        'deleted_at' => null,
    ]);
});
