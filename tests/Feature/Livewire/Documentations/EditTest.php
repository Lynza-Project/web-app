<?php

use App\Livewire\Documentations\Edit;
use App\Models\Documentation;
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

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['documentation' => $documentation])
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
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['documentation' => $documentation])
        ->assertSet('title', 'Original Title')
        ->assertSet('content', 'Original Content')
        ->assertSet('image', 'original-image.jpg');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['documentation' => $documentation])
        ->set('title', '')
        ->set('content', '')
        ->call('updateDocumentation')
        ->assertHasErrors(['title', 'content']);
});

test('it can update documentation without changing image', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['documentation' => $documentation])
        ->set('title', 'Updated Title')
        ->set('content', 'Updated Content')
        ->call('updateDocumentation')
        ->assertDispatched('documentationEdited');

    expect(Documentation::find($documentation->id))->toMatchArray([
        'title' => 'Updated Title',
        'content' => 'Updated Content',
        'image' => 'original-image.jpg',
    ]);
});

test('it can update documentation with new image', function () {
    Storage::fake('s3');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('new-image.jpg');

    Livewire::test(Edit::class, ['documentation' => $documentation])
        ->set('title', 'Updated Title')
        ->set('content', 'Updated Content')
        ->set('newImage', $file)
        ->call('updateDocumentation')
        ->assertDispatched('documentationEdited');

    // Refresh the model from the database
    $documentation->refresh();

    // Check that the title and content were updated
    expect($documentation->title)->toBe('Updated Title');
    expect($documentation->content)->toBe('Updated Content');

    // Check that the image was updated
    expect($documentation->image)->not->toBe('original-image.jpg');
    Storage::disk('s3')->assertExists($documentation->image);
});

test('it resets new image after update', function () {
    Storage::fake('s3');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $documentation = Documentation::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('new-image.jpg');

    Livewire::test(Edit::class, ['documentation' => $documentation])
        ->set('title', 'Updated Title')
        ->set('content', 'Updated Content')
        ->set('newImage', $file)
        ->call('updateDocumentation')
        ->assertSet('newImage', null);
});
