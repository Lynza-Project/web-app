<?php

use App\Helpers\UserHelper;
use App\Models\User;
use Mockery;

beforeEach(function () {
    // Mock the UserHelper methods
    $this->mock = Mockery::mock('alias:' . UserHelper::class);
    $this->mock->shouldReceive('isAdministrator')->andReturn(true)->byDefault();
    $this->mock->shouldReceive('isSuperAdministrator')->andReturn(false)->byDefault();
});

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/dashboard')->assertStatus(200);
});
