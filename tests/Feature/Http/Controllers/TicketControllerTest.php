<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the index method returns the correct view.
     */
    public function test_index_method_returns_correct_view()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('tickets.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.index');
    }

    /**
     * Test that the create method returns the correct view.
     */
    public function test_create_method_returns_correct_view()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('tickets.create'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.create');
    }

    /**
     * Test that the show method works for ticket owner.
     */
    public function test_show_method_works_for_ticket_owner()
    {
        // Arrange
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.show');
        $response->assertViewHas('ticket', $ticket);
    }

    /**
     * Test that the show method works for admin from same organization.
     */
    public function test_show_method_works_for_admin_from_same_organization()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
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
        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.show');
        $response->assertViewHas('ticket', $ticket);
    }

    /**
     * Test that the show method works for super-admin.
     */
    public function test_show_method_works_for_super_admin()
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
        $response = $this->actingAs($superAdmin)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.show');
        $response->assertViewHas('ticket', $ticket);
    }

    /**
     * Test that the show method returns 403 for unauthorized users.
     */
    public function test_show_method_returns_403_for_unauthorized_users()
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
        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the edit method works for authorized users.
     */
    public function test_edit_method_works_for_authorized_users()
    {
        // Arrange
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('tickets.edit', $ticket));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('tickets.edit');
        $response->assertViewHas('ticket', $ticket);
    }

    /**
     * Test that the edit method returns 403 for unauthorized users.
     */
    public function test_edit_method_returns_403_for_unauthorized_users()
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
        $response = $this->actingAs($user)->get(route('tickets.edit', $ticket));

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the update method works for authorized users.
     */
    public function test_update_method_works_for_authorized_users()
    {
        // Arrange
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'subject' => 'Updated Subject',
            'description' => 'Updated Description',
            'status' => 'open'
        ]);

        // Assert
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('message', 'Ticket mis à jour avec succès.');
    }

    /**
     * Test that the update method returns 403 for unauthorized users.
     */
    public function test_update_method_returns_403_for_unauthorized_users()
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
        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'subject' => 'Updated Subject',
            'description' => 'Updated Description',
            'status' => 'open'
        ]);

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the destroy method works for authorized users.
     */
    public function test_destroy_method_works_for_authorized_users()
    {
        // Arrange
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('tickets.destroy', $ticket));

        // Assert
        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('message', 'Ticket supprimé avec succès.');
        $this->assertSoftDeleted('tickets', ['id' => $ticket->id]);
    }

    /**
     * Test that the destroy method returns 403 for unauthorized users.
     */
    public function test_destroy_method_returns_403_for_unauthorized_users()
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
        $response = $this->actingAs($user)->delete(route('tickets.destroy', $ticket));

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);
    }

    /**
     * Test that admin from same organization can access ticket.
     */
    public function test_admin_from_same_organization_can_access_ticket()
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
        $response = $this->actingAs($admin)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Test that admin from different organization cannot access ticket.
     */
    public function test_admin_from_different_organization_cannot_access_ticket()
    {
        // Arrange
        $organization1 = Organization::factory()->create();
        $organization2 = Organization::factory()->create();

        $admin = User::factory()->create([
            'role' => 'admin',
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
        $response = $this->actingAs($admin)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that super-admin can access any ticket.
     */
    public function test_super_admin_can_access_any_ticket()
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
        $response = $this->actingAs($superAdmin)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Test that non-owner from same organization cannot access ticket.
     */
    public function test_non_owner_from_same_organization_cannot_access_ticket()
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

        // Act
        $response = $this->actingAs($user2)->get(route('tickets.show', $ticket));

        // Assert
        $response->assertStatus(403);
    }
}
