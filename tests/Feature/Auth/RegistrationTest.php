<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Livewire::test(Register::class)
        ->set('first_name', 'Test')
        ->set('last_name', 'User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('organization_name', 'Test Organization')
        ->set('organization_type', 'Business')
        ->call('register');

    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertTrue(Auth::check());
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'first_name' => 'Test',
        'last_name' => 'User',
        'role' => 'admin',
    ]);
    $this->assertDatabaseHas('organizations', [
        'name' => 'Test Organization',
        'type' => 'Business',
    ]);
    $this->assertDatabaseHas('themes', [
        'title' => 'Thème Bleu',
        'primary' => 'blue-500',
    ]);
});

test('validation errors are shown during registration', function () {
    $response = Livewire::test(Register::class)
        ->set('first_name', '')
        ->set('last_name', '')
        ->set('email', 'not-an-email')
        ->set('password', 'pass')
        ->set('password_confirmation', 'different-password')
        ->set('organization_name', '')
        ->set('organization_type', '')
        ->call('register');

    $response->assertHasErrors([
        'first_name',
        'last_name',
        'email',
        'password',
        'organization_name',
        'organization_type',
    ]);

    $this->assertGuest();
});

test('email must be unique', function () {
    // Create a user with the email we'll try to register with
    $existingUser = \App\Models\User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $response = Livewire::test(Register::class)
        ->set('first_name', 'Test')
        ->set('last_name', 'User')
        ->set('email', 'existing@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('organization_name', 'Test Organization')
        ->set('organization_type', 'Business')
        ->call('register');

    $response->assertHasErrors(['email' => 'unique']);
    $this->assertGuest();
});
