<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that non-admin users cannot access admin-only routes.
     * This covers line 16 in DocumentationController.
     */
    public function test_non_admin_cannot_access_admin_routes()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'user']);
        $documentation = Documentation::factory()->create();

        // Act & Assert - Test edit route
        $response = $this->actingAs($user)->get(route('documentations.edit', $documentation));
        $response->assertStatus(403);

        // Act & Assert - Test update route
        $response = $this->actingAs($user)->put(route('documentations.update', $documentation), []);
        $response->assertStatus(403);

        // Act & Assert - Test destroy route
        $response = $this->actingAs($user)->delete(route('documentations.destroy', $documentation));
        $response->assertStatus(403);
    }

    /**
     * Test that the create method returns the correct view.
     * This covers line 35 in DocumentationController.
     */
    public function test_create_method_returns_correct_view()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'admin']);

        // Act
        $response = $this->actingAs($user)->get(route('documentations.create'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('documentations.create');
    }

    /**
     * Test that the update method works correctly for authorized users.
     * This covers lines 74-80 in DocumentationController.
     */
    public function test_update_method_works_for_authorized_users()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $documentation = Documentation::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('documentations.update', $documentation), [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);

        // Assert
        $response->assertRedirect(route('documentations.show', $documentation));
        $response->assertSessionHas('success', 'Documentation mise à jour avec succès.');
    }

    /**
     * Test that the update method returns 403 for unauthorized users.
     * This covers lines 74-76 in DocumentationController.
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

        $documentation = Documentation::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->put(route('documentations.update', $documentation), [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);

        // Assert
        $response->assertStatus(403);
    }

    /**
     * Test that the destroy method works correctly for authorized users.
     * This covers lines 88-95 in DocumentationController.
     */
    public function test_destroy_method_works_for_authorized_users()
    {
        // Arrange
        $organization = Organization::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $organization->id
        ]);

        $documentation = Documentation::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('documentations.destroy', $documentation));

        // Assert
        $response->assertRedirect(route('documentations.index'));
        $response->assertSessionHas('success', 'Documentation supprimée avec succès.');
        $this->assertSoftDeleted('documentations', ['id' => $documentation->id]);
    }

    /**
     * Test that the destroy method returns 403 for unauthorized users.
     * This covers lines 88-90 in DocumentationController.
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

        $documentation = Documentation::factory()->create([
            'organization_id' => $organization2->id
        ]);

        // Act
        $response = $this->actingAs($user)->delete(route('documentations.destroy', $documentation));

        // Assert
        $response->assertStatus(403);
        $this->assertDatabaseHas('documentations', ['id' => $documentation->id]);
    }
}
