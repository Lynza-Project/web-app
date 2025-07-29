<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertStatus(200);
});

test('it mounts with user data', function () {
    $user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
    ]);

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertSet('first_name', 'John')
        ->assertSet('last_name', 'Doe')
        ->assertSet('email', 'john.doe@example.com');
});

test('it can update profile information', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('first_name', 'Jane')
        ->set('last_name', 'Smith')
        ->set('email', 'jane.smith@example.com')
        ->call('updateProfileInformation')
        ->assertDispatched('profile-updated');

    $user->refresh();

    expect($user->first_name)->toBe('Jane');
    expect($user->last_name)->toBe('Smith');
    expect($user->email)->toBe('jane.smith@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('it does not reset email_verified_at if email is not changed', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    $verifiedAt = $user->email_verified_at;

    Livewire::test(Profile::class)
        ->set('first_name', 'Jane')
        ->set('last_name', 'Smith')
        ->call('updateProfileInformation')
        ->assertDispatched('profile-updated');

    $user->refresh();

    expect($user->first_name)->toBe('Jane');
    expect($user->last_name)->toBe('Smith');
    expect($user->email_verified_at->timestamp)->toBe($verifiedAt->timestamp);
});

test('it redirects if email is already verified when resending verification', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    Notification::fake();

    Livewire::test(Profile::class)
        ->call('resendVerificationNotification')
        ->assertRedirect(route('dashboard', absolute: false));

    Notification::assertNothingSent();
});

test('it sends verification notification if email is not verified', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    Notification::fake();

    Livewire::test(Profile::class)
        ->call('resendVerificationNotification');

    Notification::assertSentTo($user, VerifyEmail::class);
    // We don't need to test the flash message since it's handled by Laravel
});
