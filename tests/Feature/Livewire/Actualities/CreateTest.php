<?php

use App\Livewire\Actualities\Create;
use App\Models\Actuality;
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
        ->call('createActuality')
        ->assertHasErrors(['title', 'content']);
});

test('it can create actuality without image', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Actuality')
        ->set('content', 'Test Content')
        ->call('createActuality')
        ->assertDispatched('actualityCreated');

    expect(Actuality::where([
        'title' => 'Test Actuality',
        'content' => 'Test Content',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
        'image' => null,
    ])->exists())->toBeTrue();
});

test('it can create actuality with image', function () {
    Storage::fake('s3');

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('actuality.jpg');

    Livewire::test(Create::class)
        ->set('title', 'Test Actuality')
        ->set('content', 'Test Content')
        ->set('image', $file)
        ->call('createActuality')
        ->assertDispatched('actualityCreated');

    expect(Actuality::where([
        'title' => 'Test Actuality',
        'content' => 'Test Content',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
    ])->exists())->toBeTrue();

    // Get the created actuality
    $actuality = Actuality::where('title', 'Test Actuality')->first();

    // Check that the image was stored
    expect($actuality->image)->not->toBeNull();
    Storage::disk('s3')->assertExists($actuality->image);
});

test('it resets form after creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Actuality')
        ->set('content', 'Test Content')
        ->call('createActuality')
        ->assertSet('title', '')
        ->assertSet('content', '')
        ->assertSet('image', null);
});
