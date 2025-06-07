<?php

use App\Models\Organization;
use App\Models\User;

test('user belongs to an organization', function () {
    $user = User::factory()->create();

    expect($user->organization)->toBeInstanceOf(Organization::class);
});

test('user has correct initials', function () {
    $user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    expect($user->initials())->toBe('J');

    $user->update(['first_name' => 'John David']);
    expect($user->initials())->toBe('JD');
});

test('user can check if super admin', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    expect($user->isSuperAdmin())->toBeFalse();

    $user->update(['role' => 'super-admin']);
    expect($user->isSuperAdmin())->toBeTrue();
});

test('user uses soft deletes', function () {
    $user = User::factory()->create();

    $user->delete();

    expect($user->trashed())->toBeTrue();
});

test('user has fillable attributes', function () {
    $user = User::factory()->create();

    $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'organization_id',
        'theme_id',
        'role',
        'profile_picture',
    ];

    expect($user->getFillable())->toBe($fillable);
});

test('user has hidden attributes', function () {
    $user = User::factory()->create();

    $hidden = [
        'password',
        'remember_token',
    ];

    expect($user->getHidden())->toBe($hidden);
});
