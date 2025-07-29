<?php

use App\Livewire\Tickets\Messages;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketMessage;
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

    Livewire::test(Messages::class, ['ticket' => $ticket])
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
    ]);

    $this->actingAs($user);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->assertSet('ticket.id', $ticket->id);
});

test('it validates required content field', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->set('content', '')
        ->call('addMessage')
        ->assertHasErrors(['content']);
});

test('it can add a message', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->set('content', 'This is a test message')
        ->call('addMessage')
        ->assertSet('content', '')
        ->assertDispatched('ticketMessageAdded');

    $this->assertDatabaseHas('ticket_messages', [
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'organization_id' => $organization->id,
        'content' => 'This is a test message',
    ]);
});

test('super admin can delete any message', function () {
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
    ]);

    $message = TicketMessage::factory()->create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($superAdmin);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->call('deleteMessage', $message)
        ->assertDispatched('ticketMessageAdded');

    $this->assertDatabaseMissing('ticket_messages', [
        'id' => $message->id,
        'deleted_at' => null,
    ]);
});

test('admin can delete messages from their organization', function () {
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
    ]);

    $message = TicketMessage::factory()->create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($admin);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->call('deleteMessage', $message)
        ->assertDispatched('ticketMessageAdded');

    $this->assertDatabaseMissing('ticket_messages', [
        'id' => $message->id,
        'deleted_at' => null,
    ]);
});

test('user can delete their own messages', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $ticket = Ticket::factory()->create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
    ]);

    $message = TicketMessage::factory()->create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->call('deleteMessage', $message)
        ->assertDispatched('ticketMessageAdded');

    $this->assertDatabaseMissing('ticket_messages', [
        'id' => $message->id,
        'deleted_at' => null,
    ]);
});

test('user cannot delete messages from other users', function () {
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
    ]);

    $message = TicketMessage::factory()->create([
        'ticket_id' => $ticket->id,
        'user_id' => $user1->id,
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user2);

    Livewire::test(Messages::class, ['ticket' => $ticket])
        ->call('deleteMessage', $message)
        ->assertHasErrors(['message']);

    $this->assertDatabaseHas('ticket_messages', [
        'id' => $message->id,
        'deleted_at' => null,
    ]);
});
