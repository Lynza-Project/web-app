<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('users cannot authenticate with invalid credentials using livewire', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors(['email']);
    $this->assertGuest();
});

test('authentication is rate limited after too many attempts', function () {
    $user = User::factory()->create();

    // Simulate hitting the rate limiter multiple times to trigger throttling
    $throttleKey = Str::transliterate(Str::lower($user->email).'|127.0.0.1');

    // Clear any existing rate limiter hits
    RateLimiter::clear($throttleKey);

    // Simulate 6 failed attempts (exceeding the limit of 5)
    for ($i = 0; $i < 6; $i++) {
        RateLimiter::hit($throttleKey);
    }

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response->assertHasErrors(['email']);
    $this->assertGuest();
});
