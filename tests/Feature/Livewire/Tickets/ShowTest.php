<?php

use App\Livewire\Tickets\Show;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Livewire;

test('the component can render', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->assertStatus(200);
});

test('it mounts with ticket data', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'status' => 'open',
    ]);

    $this->actingAs($user);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->assertSet('ticket.id', $ticket->id)
        ->assertSet('status', 'open');
});

test('super admin can update ticket status', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $superAdmin = User::factory()->create([
        'role' => 'super-admin',
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'status' => 'open',
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->call('updateStatus')
        ->assertDispatched('ticketStatusUpdated')
        ->assertRedirect(route('tickets.index'));

    $ticket->refresh();
    expect($ticket->status)->toBe('closed');
});

test('admin can update ticket status from their organization', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $admin = User::factory()->create([
        'organization_id' => $organization->id,
        'role' => 'admin',
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'status' => 'open',
    ]);

    $this->actingAs($admin);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->call('updateStatus')
        ->assertDispatched('ticketStatusUpdated')
        ->assertRedirect(route('tickets.index'));

    $ticket->refresh();
    expect($ticket->status)->toBe('closed');
});

test('user can update their own ticket status', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'status' => 'open',
    ]);

    $this->actingAs($user);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->call('updateStatus')
        ->assertDispatched('ticketStatusUpdated')
        ->assertRedirect(route('tickets.index'));

    $ticket->refresh();
    expect($ticket->status)->toBe('closed');
});

test('user cannot update ticket status from other users', function () {
    $organization = Organization::factory()->create();
    $user1 = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $user2 = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user1->id,
        'status' => 'open',
    ]);

    $this->actingAs($user2);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->call('updateStatus')
        ->assertHasErrors(['status']);

    $ticket->refresh();
    expect($ticket->status)->toBe('open');
});

test('admin cannot update ticket status from other organizations', function () {
    $organization1 = Organization::factory()->create();
    $organization2 = Organization::factory()->create();

    $user = User::factory()->create([
        'organization_id' => $organization1->id,
    ]);

    $admin = User::factory()->create([
        'organization_id' => $organization2->id,
        'role' => 'admin',
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization1->id,
        'user_id' => $user->id,
        'status' => 'open',
    ]);

    $this->actingAs($admin);

    Livewire::test(Show::class, ['ticket' => $ticket])
        ->call('updateStatus')
        ->assertHasErrors(['status']);

    $ticket->refresh();
    expect($ticket->status)->toBe('open');
});
