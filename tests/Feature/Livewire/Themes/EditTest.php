<?php

use App\Livewire\Themes\Edit;
use App\Models\Theme;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    Livewire::test(Edit::class, ['theme' => $theme])
        ->assertStatus(200);
});

test('it mounts with theme data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Original Title',
        'primary' => 'blue-500',
        'font' => 'Arial',
        'background_color' => 'white',
        'button_color' => 'blue-500',
        'logo_path' => 'original-logo.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['theme' => $theme])
        ->assertSet('title', 'Original Title')
        ->assertSet('primary', 'blue-500')
        ->assertSet('font', 'Arial')
        ->assertSet('background_color', 'white')
        ->assertSet('button_color', 'blue-500')
        ->assertSet('logo_path', 'original-logo.jpg');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['theme' => $theme])
        ->set('title', '')
        ->set('primary', '')
        ->set('font', '')
        ->call('updateTheme')
        ->assertHasErrors(['title', 'primary', 'font']);
});

test('it can update theme without changing logo', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Original Title',
        'primary' => 'blue-500',
        'font' => 'Arial',
        'background_color' => 'white',
        'button_color' => 'blue-500',
        'logo_path' => 'original-logo.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['theme' => $theme])
        ->set('title', 'Updated Title')
        ->set('primary', 'red-500')
        ->set('font', 'Helvetica')
        ->set('background_color', 'gray-100')
        ->set('button_color', 'red-500')
        ->call('updateTheme')
        ->assertDispatched('themeEdited');

    $theme->refresh();

    expect($theme->title)->toBe('Updated Title');
    expect($theme->primary)->toBe('red-500');
    expect($theme->font)->toBe('Helvetica');
    expect($theme->background_color)->toBe('gray-100');
    expect($theme->button_color)->toBe('red-500');
    expect($theme->logo_path)->toBe('original-logo.jpg');
});

test('it can update theme with new logo', function () {
    Storage::fake('s3');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $theme = Theme::factory()->create([
        'organization_id' => $organization->id,
        'title' => 'Original Title',
        'primary' => 'blue-500',
        'font' => 'Arial',
        'background_color' => 'white',
        'button_color' => 'blue-500',
        'logo_path' => 'original-logo.jpg',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('new-logo.jpg');

    Livewire::test(Edit::class, ['theme' => $theme])
        ->set('title', 'Updated Title')
        ->set('primary', 'red-500')
        ->set('font', 'Helvetica')
        ->set('background_color', 'gray-100')
        ->set('button_color', 'red-500')
        ->set('newLogo', $file)
        ->call('updateTheme')
        ->assertDispatched('themeEdited');

    $theme->refresh();

    expect($theme->title)->toBe('Updated Title');
    expect($theme->primary)->toBe('red-500');
    expect($theme->font)->toBe('Helvetica');
    expect($theme->background_color)->toBe('gray-100');
    expect($theme->button_color)->toBe('red-500');
    expect($theme->logo_path)->not->toBe('original-logo.jpg');

    Storage::disk('s3')->assertExists($theme->logo_path);
});
