<?php

use App\Livewire\Themes\Create;
use App\Models\Organization;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('it validates required fields', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', '')
        ->set('primary', '')
        ->set('font', '')
        ->call('createTheme')
        ->assertHasErrors(['title', 'primary', 'font']);
});

test('it can create a theme without logo', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'New Theme')
        ->set('primary', 'blue-500')
        ->set('font', 'Arial')
        ->set('background_color', 'white')
        ->set('button_color', 'blue-500')
        ->call('createTheme')
        ->assertDispatched('themeCreated');

    $this->assertDatabaseHas('themes', [
        'title' => 'New Theme',
        'primary' => 'blue-500',
        'font' => 'Arial',
        'background_color' => 'white',
        'button_color' => 'blue-500',
        'organization_id' => $organization->id,
    ]);
});

test('it can create a theme with logo', function () {
    Storage::fake('s3');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('logo.jpg');

    Livewire::test(Create::class)
        ->set('title', 'New Theme With Logo')
        ->set('primary', 'red-500')
        ->set('font', 'Helvetica')
        ->set('background_color', 'gray-100')
        ->set('button_color', 'red-500')
        ->set('logo', $file)
        ->call('createTheme')
        ->assertDispatched('themeCreated');

    $theme = Theme::where('title', 'New Theme With Logo')->first();

    expect($theme)->not->toBeNull();
    expect($theme->primary)->toBe('red-500');
    expect($theme->font)->toBe('Helvetica');
    expect($theme->background_color)->toBe('gray-100');
    expect($theme->button_color)->toBe('red-500');
    expect($theme->logo_path)->not->toBeNull();

    Storage::disk('s3')->assertExists($theme->logo_path);
});

test('it resets form after successful creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'New Theme')
        ->set('primary', 'blue-500')
        ->set('font', 'Arial')
        ->set('background_color', 'white')
        ->set('button_color', 'blue-500')
        ->call('createTheme')
        ->assertSet('title', '')
        ->assertSet('primary', '')
        ->assertSet('font', '')
        ->assertSet('background_color', '')
        ->assertSet('button_color', '')
        ->assertSet('logo', null);
});
