<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that non-admin users cannot access admin-only routes.
     */
    public function test_non_admin_cannot_access_admin_routes()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create();

        // Act & Assert - Test edit route
        $response = $this->actingAs($user)->get(route('events.edit', $event));
        $response->assertStatus(403);

        // Act & Assert - Test update route
        $response = $this->actingAs($user)->put(route('events.update', $event), []);
        $response->assertStatus(403);

        // Act & Assert - Test destroy route
        $response = $this->actingAs($user)->delete(route('events.destroy', $event));
        $response->assertStatus(403);
    }

    /**
     * Test that admin users can access admin-only routes.
     */
    public function test_admin_can_access_admin_routes()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act & Assert - Test edit route
        $response = $this->actingAs($user)->get(route('events.edit', $event));
        $response->assertStatus(200);

        // Act & Assert - Test update route
        $response = $this->actingAs($user)->put(route('events.update', $event), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->format('Y-m-d'),
            'location' => 'Updated Location'
        ]);
        $response->assertRedirect(route('events.show', $event));

        // Act & Assert - Test destroy route
        $response = $this->actingAs($user)->delete(route('events.destroy', $event));
        $response->assertRedirect(route('events.index'));
    }

    /**
     * Test that the index method returns the correct view.
     */
    public function test_index_method_returns_correct_view()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('events.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('events.index');
    }

    /**
     * Test that the create method returns the correct view.
     */
    public function test_create_method_returns_correct_view()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get(route('events.create'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('events.create');
    }

    /**
     * Test that the show method works for authorized users.
     */
    public function test_show_method_works_for_authorized_users()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.show', $event));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertViewHas('event', $event);
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
            'role' => 'user',
            'organization_id' => $organization1->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.show', $event));

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the edit method works for authorized users.
     */
    public function test_edit_method_works_for_authorized_users()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.edit', $event));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
        $response->assertViewHas('event', $event);
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
            'role' => 'admin',
            'organization_id' => $organization1->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.edit', $event));

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the update method works for authorized users.
     */
    public function test_update_method_works_for_authorized_users()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('events.update', $event), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->format('Y-m-d'),
            'location' => 'Updated Location'
        ]);

        // Assert
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('success', 'Événement mis à jour avec succès.');
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
            'role' => 'admin',
            'organization_id' => $organization1->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('events.update', $event), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->format('Y-m-d'),
            'location' => 'Updated Location'
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
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('events.destroy', $event));

        // Assert
        $response->assertRedirect(route('events.index'));
        $response->assertSessionHas('success', 'Événement supprimé avec succès.');
        $this->assertSoftDeleted('events', ['id' => $event->id]);
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
            'role' => 'admin',
            'organization_id' => $organization1->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('events.destroy', $event));

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    /**
     * Test that super-admin users can access any event.
     */
    public function test_super_admin_can_access_any_event()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'super-admin'
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act & Assert - Test show route
        $response = $this->actingAs($user)->get(route('events.show', $event));
        $response->assertStatus(200);

        // Act & Assert - Test edit route
        $response = $this->actingAs($user)->get(route('events.edit', $event));
        $response->assertStatus(200);

        // Act & Assert - Test update route
        $response = $this->actingAs($user)->put(route('events.update', $event), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->format('Y-m-d'),
            'location' => 'Updated Location'
        ]);
        $response->assertRedirect(route('events.show', $event));

        // Act & Assert - Test destroy route
        $response = $this->actingAs($user)->delete(route('events.destroy', $event));
        $response->assertRedirect(route('events.index'));
    }

    /**
     * Test that users from the same organization can access events.
     */
    public function test_user_from_same_organization_can_access_event()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'user',
            'organization_id' => $organization->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.show', $event));

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Test that users from different organizations cannot access events.
     */
    public function test_user_from_different_organization_cannot_access_event()
    {
        // Arrange
        $organization1 = Organization::factory()->create();
        $organization2 = Organization::factory()->create();

        $user = User::factory()->create([
            'role' => 'user',
            'organization_id' => $organization1->id
        ]);

        $event = Event::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('events.show', $event));

        // Assert
        $response->assertStatus(403);
    }
}
