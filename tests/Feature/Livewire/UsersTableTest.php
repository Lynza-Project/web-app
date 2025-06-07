<?php

use App\Livewire\Users\Table;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Table::class)
        ->assertStatus(200);
});

test('it displays users for current organization', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create additional users for this organization
    $users = User::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    // Create users for another organization
    $otherOrganization = Organization::factory()->create();
    User::factory()->count(2)->create([
        'organization_id' => $otherOrganization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Table::class)
        ->assertViewHas('users', function ($viewUsers) use ($organization) {
            return $viewUsers->count() === 4 && // 3 created + 1 authenticated user
                $viewUsers->pluck('organization_id')->unique()->first() === $organization->id;
        });
});

test('it can sort users', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create users with different names
    User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Zack',
        'created_at' => now()->subDay(),
    ]);

    User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Adam',
        'created_at' => now(),
    ]);

    $this->actingAs($user);

    // Test default sorting (created_at desc)
    Livewire::test(Table::class)
        ->assertSet('sortField', 'created_at')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'first_name')
        ->assertSet('sortField', 'first_name')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'first_name')
        ->assertSet('sortDirection', 'desc');
});

test('it can search users', function () {
    // Create an organization and user
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    // Create users with different names and emails
    User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'John',
        'email' => 'john@example.com',
    ]);

    User::factory()->create([
        'organization_id' => $organization->id,
        'first_name' => 'Jane',
        'email' => 'jane@example.com',
    ]);

    $this->actingAs($user);

    // Test search by name
    Livewire::test(Table::class)
        ->set('search', 'John')
        ->assertViewHas('users', function ($viewUsers) {
            return $viewUsers->count() === 1 &&
                $viewUsers->first()->first_name === 'John';
        });

    // Test search by email
    Livewire::test(Table::class)
        ->set('search', 'jane@example')
        ->assertViewHas('users', function ($viewUsers) {
            return $viewUsers->count() === 1 &&
                $viewUsers->first()->email === 'jane@example.com';
        });
});

test('it responds to user events', function () {
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Table::class)
        ->call('userCreated')
        ->assertDispatched('refresh')
        ->call('userUpdated')
        ->assertDispatched('refresh')
        ->call('userDeleted')
        ->assertDispatched('refresh');
});

test('it sets canDelete based on user role', function () {
    // Regular user
    $user = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'user',
    ]);

    $this->actingAs($user);

    Livewire::test(Table::class)
        ->assertSet('canDelete', false);

    // Admin user
    $admin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    Livewire::test(Table::class)
        ->assertSet('canDelete', true);

    // Super admin
    $superAdmin = User::factory()->create([
        'organization_id' => Organization::factory()->create()->id,
        'role' => 'super-admin',
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Table::class)
        ->assertSet('canDelete', true);
});
