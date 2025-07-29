<?php

namespace Tests\Unit\Models;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_message_can_be_created()
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);
        $ticket = Ticket::factory()->create([
            'organization_id' => $organization->id,
            'user_id' => $user->id
        ]);

        $ticketMessage = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'content' => 'This is a test message',
        ]);

        $this->assertInstanceOf(TicketMessage::class, $ticketMessage);
        $this->assertEquals('This is a test message', $ticketMessage->content);
        $this->assertEquals($ticket->id, $ticketMessage->ticket_id);
        $this->assertEquals($user->id, $ticketMessage->user_id);
        $this->assertEquals($organization->id, $ticketMessage->organization_id);
    }

    public function test_ticket_message_belongs_to_ticket()
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);
        $ticket = Ticket::factory()->create([
            'organization_id' => $organization->id,
            'user_id' => $user->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(Ticket::class, $ticketMessage->ticket);
        $this->assertEquals($ticket->id, $ticketMessage->ticket->id);
    }

    public function test_ticket_message_belongs_to_user()
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);
        $ticket = Ticket::factory()->create([
            'organization_id' => $organization->id,
            'user_id' => $user->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(User::class, $ticketMessage->user);
        $this->assertEquals($user->id, $ticketMessage->user->id);
    }

    public function test_ticket_message_belongs_to_organization()
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);
        $ticket = Ticket::factory()->create([
            'organization_id' => $organization->id,
            'user_id' => $user->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(Organization::class, $ticketMessage->organization);
        $this->assertEquals($organization->id, $ticketMessage->organization->id);
    }
}
