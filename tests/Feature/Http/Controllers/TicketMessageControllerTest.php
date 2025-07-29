<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the store method works for ticket owner.
     */
    public function test_store_method_works_for_ticket_owner()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->post(route('ticket-messages.store', $ticket), [
            'content' => 'Test message content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message ajouté avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'content' => 'Test message content'
        ]);
    }

    /**
     * Test that the store method works for admin from same organization.
     */
    public function test_store_method_works_for_admin_from_same_organization()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $admin = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $ticketOwner = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $ticketOwner->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($admin)->post(route('ticket-messages.store', $ticket), [
            'content' => 'Admin message content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message ajouté avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'user_id' => $admin->id,
            'organization_id' => $organization->id,
            'content' => 'Admin message content'
        ]);
    }

    /**
     * Test that the store method works for super-admin.
     */
    public function test_store_method_works_for_super_admin()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $superAdmin = User::factory()->create([
            'role' => 'super-admin'
        ]);

        $ticketOwner = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $ticketOwner->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($superAdmin)->post(route('ticket-messages.store', $ticket), [
            'content' => 'Super admin message content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message ajouté avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'user_id' => $superAdmin->id,
            'organization_id' => $organization->id,
            'content' => 'Super admin message content'
        ]);
    }

    /**
     * Test that the store method returns 403 for unauthorized users.
     */
    public function test_store_method_returns_403_for_unauthorized_users()
    {
        // Arrange
        $organization1 = Organization::factory()->create();
        $organization2 = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $organization1->id
        ]);

        $ticketOwner = User::factory()->create([
            'organization_id' => $organization2->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $ticketOwner->id,
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->post(route('ticket-messages.store', $ticket), [
            'content' => 'Unauthorized message content'
        ]);

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseMissing('ticket_messages', [
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'content' => 'Unauthorized message content'
        ]);
    }

    /**
     * Test that the update method works for message owner.
     */
    public function test_update_method_works_for_message_owner()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'content' => 'Original content'
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('ticket-messages.update', $ticketMessage), [
            'content' => 'Updated content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message mis à jour avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'id' => $ticketMessage->id,
            'content' => 'Updated content'
        ]);
    }

    /**
     * Test that the update method works for admin from same organization.
     */
    public function test_update_method_works_for_admin_from_same_organization()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $admin = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'content' => 'Original content'
        ]);

        // Act
        $response = $this->actingAs($admin)->put(route('ticket-messages.update', $ticketMessage), [
            'content' => 'Admin updated content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message mis à jour avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'id' => $ticketMessage->id,
            'content' => 'Admin updated content'
        ]);
    }

    /**
     * Test that the update method works for super-admin.
     */
    public function test_update_method_works_for_super_admin()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $superAdmin = User::factory()->create([
            'role' => 'super-admin'
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'content' => 'Original content'
        ]);

        // Act
        $response = $this->actingAs($superAdmin)->put(route('ticket-messages.update', $ticketMessage), [
            'content' => 'Super admin updated content'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message mis à jour avec succès.');
        $this->assertDatabaseHas('ticket_messages', [
            'id' => $ticketMessage->id,
            'content' => 'Super admin updated content'
        ]);
    }

    /**
     * Test that the update method returns 403 for unauthorized users.
     */
    public function test_update_method_returns_403_for_unauthorized_users()
    {
        // Arrange
        $organization1 = Organization::factory()->create();
        $organization2 = Organization::factory()->create();

        $user1 = User::factory()->create([
            'organization_id' => $organization1->id
        ]);

        $user2 = User::factory()->create([
            'organization_id' => $organization2->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user2->id,
            'organization_id' => $organization2->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user2->id,
            'organization_id' => $organization2->id,
            'content' => 'Original content'
        ]);

        // Act
        $response = $this->actingAs($user1)->put(route('ticket-messages.update', $ticketMessage), [
            'content' => 'Unauthorized updated content'
        ]);

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseHas('ticket_messages', [
            'id' => $ticketMessage->id,
            'content' => 'Original content'
        ]);
    }

    /**
     * Test that the destroy method works for message owner.
     */
    public function test_destroy_method_works_for_message_owner()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('ticket-messages.destroy', $ticketMessage));

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message supprimé avec succès.');
        $this->assertSoftDeleted('ticket_messages', ['id' => $ticketMessage->id]);
    }

    /**
     * Test that the destroy method works for admin from same organization.
     */
    public function test_destroy_method_works_for_admin_from_same_organization()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $admin = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($admin)->delete(route('ticket-messages.destroy', $ticketMessage));

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message supprimé avec succès.');
        $this->assertSoftDeleted('ticket_messages', ['id' => $ticketMessage->id]);
    }

    /**
     * Test that the destroy method works for super-admin.
     */
    public function test_destroy_method_works_for_super_admin()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $superAdmin = User::factory()->create([
            'role' => 'super-admin'
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($superAdmin)->delete(route('ticket-messages.destroy', $ticketMessage));

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Message supprimé avec succès.');
        $this->assertSoftDeleted('ticket_messages', ['id' => $ticketMessage->id]);
    }

    /**
     * Test that the destroy method returns 403 for unauthorized users.
     */
    public function test_destroy_method_returns_403_for_unauthorized_users()
    {
        // Arrange
        $organization1 = Organization::factory()->create();
        $organization2 = Organization::factory()->create();

        $user1 = User::factory()->create([
            'organization_id' => $organization1->id
        ]);

        $user2 = User::factory()->create([
            'organization_id' => $organization2->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user2->id,
            'organization_id' => $organization2->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user2->id,
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user1)->delete(route('ticket-messages.destroy', $ticketMessage));

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseHas('ticket_messages', ['id' => $ticketMessage->id]);
    }

    /**
     * Test that non-owner from same organization cannot access ticket message.
     */
    public function test_non_owner_from_same_organization_cannot_access_ticket_message()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user1 = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $user2 = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $ticket = Ticket::factory()->create([
            'user_id' => $user1->id,
            'organization_id' => $organization->id
        ]);

        $ticketMessage = TicketMessage::factory()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user1->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user2)->put(route('ticket-messages.update', $ticketMessage), [
            'content' => 'Updated by non-owner'
        ]);

        // Assert
        $response->assertStatus(403);
    }
}
