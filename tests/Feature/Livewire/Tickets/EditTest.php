<?php

use App\Livewire\Tickets\Edit;
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

    Livewire::test(Edit::class, ['ticket' => $ticket])
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
        'subject' => 'Original Subject',
        'description' => 'Original Description',
        'status' => 'open',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['ticket' => $ticket])
        ->assertSet('subject', 'Original Subject')
        ->assertSet('description', 'Original Description')
        ->assertSet('status', 'open');
});

test('it validates required fields', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['ticket' => $ticket])
        ->set('subject', '')
        ->set('description', '')
        ->call('updateTicket')
        ->assertHasErrors(['subject', 'description']);
});

test('it validates status field', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['ticket' => $ticket])
        ->set('status', 'invalid-status')
        ->call('updateTicket')
        ->assertHasErrors(['status']);
});

test('it can update a ticket', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'subject' => 'Original Subject',
        'description' => 'Original Description',
        'status' => 'open',
    ]);

    $this->actingAs($user);

    Livewire::test(Edit::class, ['ticket' => $ticket])
        ->set('subject', 'Updated Subject')
        ->set('description', 'Updated Description')
        ->set('status', 'closed')
        ->call('updateTicket')
        ->assertDispatched('ticketUpdated')
        ->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh();

    expect($ticket->subject)->toBe('Updated Subject');
    expect($ticket->description)->toBe('Updated Description');
    expect($ticket->status)->toBe('closed');
});
