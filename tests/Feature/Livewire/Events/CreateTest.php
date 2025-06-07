<?php

use App\Livewire\Events\Create;
use App\Models\Event;
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
        ->call('createEvent')
        ->assertHasErrors(['title', 'description', 'start_date', 'location']);
});

test('it validates date fields', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', 'invalid-date')
        ->call('createEvent')
        ->assertHasErrors(['start_date']);

    // End date must be after or equal to start date
    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('end_date', now()->subDay())
        ->call('createEvent')
        ->assertHasErrors(['end_date']);
});

test('it validates time fields', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    // Invalid time format
    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('start_time', 'invalid-time')
        ->call('createEvent')
        ->assertHasErrors(['start_time']);

    // End time must be after start time
    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('start_time', '10:00')
        ->set('end_time', '09:00')
        ->call('createEvent')
        ->assertHasErrors(['end_time']);
});

test('it can create event without image', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->call('createEvent')
        ->assertDispatched('eventCreated');

    expect(Event::where([
        'title' => 'Test Event',
        'description' => 'Test Description',
        'location' => 'Test Location',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
        'image' => null,
    ])->exists())->toBeTrue();
});

test('it can create event with image', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('event.jpg');

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('image', $file)
        ->call('createEvent')
        ->assertDispatched('eventCreated');

    expect(Event::where([
        'title' => 'Test Event',
        'description' => 'Test Description',
        'location' => 'Test Location',
        'organization_id' => $user->organization_id,
        'user_id' => $user->id,
    ])->exists())->toBeTrue();

    // Get the created event
    $event = Event::where('title', 'Test Event')->first();

    // Check that the image was stored
    expect($event->image)->not->toBeNull();
    Storage::disk('public')->assertExists($event->image);
});

test('it can create event with date range', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    $startDate = now();
    $endDate = now()->addDays(3);

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', $startDate)
        ->set('end_date', $endDate)
        ->call('createEvent')
        ->assertDispatched('eventCreated');

    $event = Event::where('title', 'Test Event')->first();
    expect($event->start_date->toDateString())->toBe($startDate->toDateString());
    expect($event->end_date->toDateString())->toBe($endDate->toDateString());
});

test('it can create event with time range', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('start_time', '09:00')
        ->set('end_time', '17:00')
        ->call('createEvent')
        ->assertDispatched('eventCreated');

    $event = Event::where('title', 'Test Event')->first();
    expect($event->start_time->format('H:i'))->toBe('09:00');
    expect($event->end_time->format('H:i'))->toBe('17:00');
});

test('it resets form after creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('title', 'Test Event')
        ->set('description', 'Test Description')
        ->set('location', 'Test Location')
        ->set('start_date', now())
        ->set('end_date', now()->addDay())
        ->set('start_time', '09:00')
        ->set('end_time', '17:00')
        ->call('createEvent')
        ->assertSet('title', '')
        ->assertSet('description', '')
        ->assertSet('location', '')
        ->assertSet('start_date', null)
        ->assertSet('end_date', null)
        ->assertSet('start_time', null)
        ->assertSet('end_time', null)
        ->assertSet('image', null);
});
