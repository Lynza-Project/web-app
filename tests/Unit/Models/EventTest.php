<?php

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('event belongs to an organization', function () {
    $event = Event::factory()->create();

    expect($event->organization)->toBeInstanceOf(Organization::class);
});

test('event belongs to a user', function () {
    $event = Event::factory()->create();

    expect($event->user)->toBeInstanceOf(User::class);
});

test('event has fillable attributes', function () {
    $event = Event::factory()->create();

    $fillable = [
        'organization_id',
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'image',
    ];

    expect($event->getFillable())->toBe($fillable);
});

test('event uses soft deletes', function () {
    $event = Event::factory()->create();

    $event->delete();

    expect($event->trashed())->toBeTrue();
});

test('event has image_url attribute', function () {
    // Mock the Storage facade
    Storage::fake('s3');

    // Create event with image
    $event = Event::factory()->create([
        'image' => 'events/1/test-image.jpg'
    ]);

    // Test with image
    expect($event->image_url)->not->toBeNull();

    // Create event without image
    $event = Event::factory()->create([
        'image' => null
    ]);

    // Test without image (should return default image)
    expect($event->image_url)->toBe(asset('img\university.jpg'));
});

test('event can check if it is a single day event', function () {
    // Single day event (no end date)
    $event = Event::factory()->create([
        'start_date' => now(),
        'end_date' => null,
    ]);

    expect($event->isSingleDayEvent())->toBeTrue();

    // Single day event (same start and end date)
    $event = Event::factory()->create([
        'start_date' => now(),
        'end_date' => now(),
    ]);

    expect($event->isSingleDayEvent())->toBeTrue();

    // Multi-day event
    $event = Event::factory()->create([
        'start_date' => now(),
        'end_date' => now()->addDay(),
    ]);

    expect($event->isSingleDayEvent())->toBeFalse();
});

test('event can check if it has time information', function () {
    // Event with time info
    $event = Event::factory()->create([
        'start_time' => now(),
    ]);

    expect($event->hasTimeInfo())->toBeTrue();

    // Event without time info
    $event = Event::factory()->create([
        'start_time' => null,
    ]);

    expect($event->hasTimeInfo())->toBeFalse();
});

test('event can format date range', function () {
    // Single day event
    $event = Event::factory()->create([
        'start_date' => '2023-01-01',
        'end_date' => null,
    ]);

    expect($event->getFormattedDateRange())->toBe('01 January 2023');

    // Multi-day event
    $event = Event::factory()->create([
        'start_date' => '2023-01-01',
        'end_date' => '2023-01-03',
    ]);

    expect($event->getFormattedDateRange())->toBe('01 January 2023 - 03 January 2023');
});

test('event can format time range', function () {
    // Event with start time only
    $event = Event::factory()->create([
        'start_time' => '09:00',
        'end_time' => null,
    ]);

    expect($event->getFormattedTimeRange())->toBe('09:00');

    // Event with start and end time
    $event = Event::factory()->create([
        'start_time' => '09:00',
        'end_time' => '17:00',
    ]);

    expect($event->getFormattedTimeRange())->toBe('09:00 - 17:00');

    // Event without time info
    $event = Event::factory()->create([
        'start_time' => null,
        'end_time' => null,
    ]);

    expect($event->getFormattedTimeRange())->toBeNull();
});
