<?php

use App\Livewire\Users\Create;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        ->call('createUser')
        ->assertHasErrors(['first_name', 'last_name', 'email']);
});

test('it validates email format', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'invalid-email')
        ->set('role', 'user')
        ->call('createUser')
        ->assertHasErrors(['email']);
});

test('it validates email uniqueness', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
        'email' => 'existing@example.com',
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'existing@example.com')
        ->set('role', 'user')
        ->call('createUser')
        ->assertHasErrors(['email']);
});

test('it can create a user', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john.doe@example.com')
        ->set('role', 'user')
        ->call('createUser')
        ->assertDispatched('userCreated');

    expect(User::where([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'role' => 'user',
        'organization_id' => $user->organization_id,
    ])->exists())->toBeTrue();
});

test('it sets default password for new users', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john.doe@example.com')
        ->set('role', 'user')
        ->call('createUser');

    $newUser = User::where('email', 'john.doe@example.com')->first();

    // Check that the password is hashed and matches the default 'password'
    expect(Hash::check('password', $newUser->password))->toBeTrue();
});

test('it resets form after creation', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Create::class)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('email', 'john.doe@example.com')
        ->set('role', 'user')
        ->call('createUser')
        ->assertSet('first_name', '')
        ->assertSet('last_name', '')
        ->assertSet('email', '')
        ->assertSet('role', 'user'); // Default value
});
