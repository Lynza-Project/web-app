<?php

use App\Livewire\Documentations\Create;
use App\Models\Documentation;
use App\Models\Organization;
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
        ->call('createDocumentation')
        ->assertHasErrors(['title', 'content']);
});

test('it can create documentation without image', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Documentation')
        ->set('content', 'Test Content')
        ->call('createDocumentation')
        ->assertDispatched('documentationCreated');

    expect(Documentation::where([
        'title' => 'Test Documentation',
        'content' => 'Test Content',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
        'image' => null,
    ])->exists())->toBeTrue();
});

test('it can create documentation with image', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('documentation.jpg');

    Livewire::test(Create::class)
        ->set('title', 'Test Documentation')
        ->set('content', 'Test Content')
        ->set('image', $file)
        ->call('createDocumentation')
        ->assertDispatched('documentationCreated');

    expect(Documentation::where([
        'title' => 'Test Documentation',
        'content' => 'Test Content',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
    ])->exists())->toBeTrue();

    // Get the created documentation
    $documentation = Documentation::where('title', 'Test Documentation')->first();

    // Check that the image was stored
    expect($documentation->image)->not->toBeNull();
    Storage::disk('public')->assertExists($documentation->image);
});

test('it resets form after creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Documentation')
        ->set('content', 'Test Content')
        ->call('createDocumentation')
        ->assertSet('title', '')
        ->assertSet('content', '')
        ->assertSet('image', null);
});
