<?php

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->mock = Mockery::mock(UserHelper::class);
});

it('displays the index page when user is an administrator', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertStatus(200)
        ->assertViewIs('users.index');
});

it('forbids access to index page when user is not an administrator', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertStatus(403);
});

it('forbids access to index page for guests', function () {
    $this->mock->shouldReceive('isAdministrator')->andReturn(false);

    $this->get(route('users.index'))
        ->assertStatus(302);
});

it('allows super-admin to access index page', function () {
    $user = User::factory()->create(['role' => 'super-admin']);

    $this->mock->shouldReceive('isAdministrator')->andReturn(true);

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertStatus(200)
        ->assertViewIs('users.index');
});
