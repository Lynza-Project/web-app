<?php

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('isAdministrator returns true for admin user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'admin']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isAdministrator())->toBeTrue();
});

test('isAdministrator returns true for super-admin user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'super-admin']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isAdministrator())->toBeTrue();
});

test('isAdministrator returns false for regular user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isAdministrator())->toBeFalse();
});

test('isSuperAdministrator returns true for super-admin user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'super-admin']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isSuperAdministrator())->toBeTrue();
});

test('isSuperAdministrator returns false for admin user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'admin']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isSuperAdministrator())->toBeFalse();
});

test('isSuperAdministrator returns false for regular user', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    // Act & Assert
    expect(UserHelper::isSuperAdministrator())->toBeFalse();
});
