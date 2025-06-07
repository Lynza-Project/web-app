<?php

use App\Livewire\Actualities\Edit;
use App\Models\Actuality;
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

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['actuality' => $actuality])
        ->assertStatus(200);
});

test('it mounts with actuality data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['actuality' => $actuality])
        ->assertSet('title', 'Original Title')
        ->assertSet('content', 'Original Content')
        ->assertSet('image', 'original-image.jpg');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['actuality' => $actuality])
        ->set('title', '')
        ->set('content', '')
        ->call('updateActuality')
        ->assertHasErrors(['title', 'content']);
});

test('it can update actuality without changing image', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['actuality' => $actuality])
        ->set('title', 'Updated Title')
        ->set('content', 'Updated Content')
        ->call('updateActuality')
        ->assertDispatched('actualityEdited');

    expect(Actuality::find($actuality->id))->toMatchArray([
        'title' => 'Updated Title',
        'content' => 'Updated Content',
        'image' => 'original-image.jpg',
    ]);
});

test('it can update actuality with new image', function () {
    Storage::fake('public');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $actuality = Actuality::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'content' => 'Original Content',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('new-image.jpg');

    Livewire::test(Edit::class, ['actuality' => $actuality])
        ->set('title', 'Updated Title')
        ->set('content', 'Updated Content')
        ->set('newImage', $file)
        ->call('updateActuality')
        ->assertDispatched('actualityEdited');

    // Refresh the model from the database
    $actuality->refresh();

    // Check that the title and content were updated
    expect($actuality->title)->toBe('Updated Title');
    expect($actuality->content)->toBe('Updated Content');

    // Check that the image was updated
    expect($actuality->image)->not->toBe('original-image.jpg');
    Storage::disk('public')->assertExists($actuality->image);
});
