<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('verification notification can be sent', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    Notification::fake();

    Livewire::test(\App\Livewire\Auth\VerifyEmail::class)
        ->call('sendVerification');

    Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);

    Session::shouldReceive('flash')->with('status', 'verification-link-sent');
});

test('verification notification is not sent if email is already verified', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);

    Notification::fake();

    $response = Livewire::test(\App\Livewire\Auth\VerifyEmail::class)
        ->call('sendVerification');

    Notification::assertNothingSent();

    $response->assertRedirect(route('dashboard', absolute: false));
});

test('user can logout from verification page', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = Livewire::test(\App\Livewire\Auth\VerifyEmail::class)
        ->call('logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
