<?php

use App\Livewire\Events\Edit;
use App\Models\Event;
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

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['event' => $event])
        ->assertStatus(200);
});

test('it mounts with event data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'description' => 'Original Description',
        'location' => 'Original Location',
        'start_date' => now(),
        'end_date' => now()->addDay(),
        'start_time' => now(),
        'end_time' => now()->addHour(),
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['event' => $event])
        ->assertSet('title', 'Original Title')
        ->assertSet('description', 'Original Description')
        ->assertSet('location', 'Original Location')
        ->assertSet('start_date', $event->start_date)
        ->assertSet('end_date', $event->end_date)
        ->assertSet('start_time', $event->start_time->format('H:i'))
        ->assertSet('end_time', $event->end_time->format('H:i'))
        ->assertSet('image', 'original-image.jpg');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['event' => $event])
        ->set('title', '')
        ->set('description', '')
        ->set('location', '')
        ->set('start_date', '')
        ->call('updateEvent')
        ->assertHasErrors(['title', 'description', 'location', 'start_date']);
});

test('it validates date and time fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    // Test end_date must be after or equal to start_date
    Livewire::test(Edit::class, ['event' => $event])
        ->set('start_date', now())
        ->set('end_date', now()->subDay())
        ->call('updateEvent')
        ->assertHasErrors(['end_date']);

    // Test end_time must be after start_time
    Livewire::test(Edit::class, ['event' => $event])
        ->set('start_time', '14:00')
        ->set('end_time', '13:00')
        ->call('updateEvent')
        ->assertHasErrors(['end_time']);

    // Test time format validation
    Livewire::test(Edit::class, ['event' => $event])
        ->set('start_time', 'invalid-time')
        ->call('updateEvent')
        ->assertHasErrors(['start_time']);
});

test('it can update event without changing image', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'description' => 'Original Description',
        'location' => 'Original Location',
        'start_date' => now(),
        'end_date' => now()->addDay(),
        'start_time' => now(),
        'end_time' => now()->addHour(),
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    $newStartDate = now()->addDays(2);
    $newEndDate = now()->addDays(3);

    Livewire::test(Edit::class, ['event' => $event])
        ->set('title', 'Updated Title')
        ->set('description', 'Updated Description')
        ->set('location', 'Updated Location')
        ->set('start_date', $newStartDate)
        ->set('end_date', $newEndDate)
        ->set('start_time', '10:00')
        ->set('end_time', '11:00')
        ->call('updateEvent')
        ->assertDispatched('eventEdited');

    $event->refresh();

    expect($event->title)->toBe('Updated Title');
    expect($event->description)->toBe('Updated Description');
    expect($event->location)->toBe('Updated Location');
    expect($event->start_date->toDateString())->toBe($newStartDate->toDateString());
    expect($event->end_date->toDateString())->toBe($newEndDate->toDateString());
    expect($event->start_time->format('H:i'))->toBe('10:00');
    expect($event->end_time->format('H:i'))->toBe('11:00');
    expect($event->image)->toBe('original-image.jpg');
});

test('it can update event with new image', function () {
    Storage::fake('s3');

    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $event = Event::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'title' => 'Original Title',
        'description' => 'Original Description',
        'location' => 'Original Location',
        'image' => 'original-image.jpg',
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('new-image.jpg');

    Livewire::test(Edit::class, ['event' => $event])
        ->set('title', 'Updated Title')
        ->set('description', 'Updated Description')
        ->set('location', 'Updated Location')
        ->set('start_date', now())
        ->set('newImage', $file)
        ->call('updateEvent')
        ->assertDispatched('eventEdited');

    $event->refresh();

    expect($event->title)->toBe('Updated Title');
    expect($event->description)->toBe('Updated Description');
    expect($event->location)->toBe('Updated Location');
    expect($event->image)->not->toBe('original-image.jpg');
    Storage::disk('s3')->assertExists($event->image);
});
