<?php

use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;

test('documentation belongs to an organization', function () {
    $documentation = Documentation::factory()->create();

    expect($documentation->organization)->toBeInstanceOf(Organization::class);
});

test('documentation belongs to a user', function () {
    $documentation = Documentation::factory()->create();

    expect($documentation->user)->toBeInstanceOf(User::class);
});

test('documentation has image_url attribute', function () {
    // Mock the Storage facade
    Storage::fake('s3');

    // Create documentation with image
    $documentation = Documentation::factory()->create([
        'image' => 'documentations/1/test-image.jpg'
    ]);

    // Test with image
    expect($documentation->image_url)->not->toBeNull();

    // Create documentation without an image
    $documentation = Documentation::factory()->create([
        'image' => null
    ]);

    // Test without an image (should return default image)
    expect($documentation->image_url)->toBe(asset('img\university.jpg'));
});

test('documentation uses soft deletes', function () {
    $documentation = Documentation::factory()->create();

    $documentation->delete();

    expect($documentation->trashed())->toBeTrue();
});
