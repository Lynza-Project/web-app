<?php

use App\Models\Actuality;
use App\Models\Organization;
use App\Models\User;

test('actuality belongs to an organization', function () {
    $actuality = Actuality::factory()->create();

    expect($actuality->organization)->toBeInstanceOf(Organization::class);
});

test('actuality belongs to a user', function () {
    $actuality = Actuality::factory()->create();

    expect($actuality->user)->toBeInstanceOf(User::class);
});

test('actuality has fillable attributes', function () {
    $actuality = Actuality::factory()->create();

    $fillable = [
        'organization_id',
        'user_id',
        'title',
        'content',
        'image',
    ];

    expect($actuality->getFillable())->toBe($fillable);
});

test('actuality uses soft deletes', function () {
    $actuality = Actuality::factory()->create();

    $actuality->delete();

    expect($actuality->trashed())->toBeTrue();
});
