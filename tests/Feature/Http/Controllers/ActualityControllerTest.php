<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Actuality;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\UserHelper;

class ActualityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that the index page is displayed correctly.
     */
    public function test_displays_the_index_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('actualities.index'))
            ->assertStatus(200)
            ->assertViewIs('actualities.index');
    }

    /**
     * Test that the show page is displayed for an actuality when user has access.
     */
    public function test_displays_the_show_page_for_an_actuality_when_user_has_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create(['organization_id' => $actuality->organization_id]);

        $this->actingAs($user)
            ->get(route('actualities.show', $actuality))
            ->assertStatus(200)
            ->assertViewIs('actualities.show')
            ->assertViewHas('actuality', $actuality);
    }

    /**
     * Test that access is forbidden to show page for an actuality when user does not have access.
     */
    public function test_forbids_access_to_show_page_for_an_actuality_when_user_does_not_have_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create(); // Different organization

        $this->actingAs($user)
            ->get(route('actualities.show', $actuality))
            ->assertStatus(403);
    }

    /**
     * Test that the edit page is displayed for an actuality when user is an administrator and has access.
     */
    public function test_displays_the_edit_page_for_an_actuality_when_user_is_an_administrator_and_has_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $actuality->organization_id
        ]);

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->get(route('actualities.edit', $actuality))
            ->assertStatus(200)
            ->assertViewIs('actualities.edit')
            ->assertViewHas('actuality', $actuality);
    }

    /**
     * Test that access is forbidden to edit page for an actuality when user is not an administrator.
     */
    public function test_forbids_access_to_edit_page_for_an_actuality_when_user_is_not_an_administrator()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'organization_id' => $actuality->organization_id
        ]);

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(false);
        });

        $this->actingAs($user)
            ->get(route('actualities.edit', $actuality))
            ->assertStatus(403);
    }

    /**
     * Test that access is forbidden to edit page for an actuality when user does not have access.
     */
    public function test_forbids_access_to_edit_page_for_an_actuality_when_user_does_not_have_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin'
        ]); // Different organization

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->get(route('actualities.edit', $actuality))
            ->assertStatus(403);
    }

    /**
     * Test that an actuality is updated when user is an administrator and has access.
     */
    public function test_updates_an_actuality_when_user_is_an_administrator_and_has_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $actuality->organization_id
        ]);

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->put(route('actualities.update', $actuality))
            ->assertRedirect(route('actualities.show', $actuality))
            ->assertSessionHas('success', 'Actualité mise à jour avec succès.');
    }

    /**
     * Test that access is forbidden to update an actuality when user does not have access.
     */
    public function test_forbids_access_to_update_an_actuality_when_user_does_not_have_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin'
        ]); // Different organization

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->put(route('actualities.update', $actuality))
            ->assertStatus(403);
    }

    /**
     * Test that the create page is displayed correctly.
     */
    public function test_displays_the_create_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('actualities.create'))
            ->assertStatus(200)
            ->assertViewIs('actualities.create');
    }

    /**
     * Test that super-admin can access any actuality.
     */
    public function test_super_admin_can_access_any_actuality()
    {
        $actuality = Actuality::factory()->create();
        $superAdmin = User::factory()->create([
            'role' => 'super-admin'
        ]);

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        // Test show route
        $this->actingAs($superAdmin)
            ->get(route('actualities.show', $actuality))
            ->assertStatus(200);

        // Test edit route
        $this->actingAs($superAdmin)
            ->get(route('actualities.edit', $actuality))
            ->assertStatus(200);

        // Test update route
        $this->actingAs($superAdmin)
            ->put(route('actualities.update', $actuality))
            ->assertRedirect(route('actualities.show', $actuality));

        // Test destroy route
        $this->actingAs($superAdmin)
            ->delete(route('actualities.destroy', $actuality))
            ->assertRedirect(route('actualities.index'));
    }

    /**
     * Test that an actuality is destroyed when user is an administrator and has access.
     */
    public function test_destroys_an_actuality_when_user_is_an_administrator_and_has_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $actuality->organization_id
        ]);

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->delete(route('actualities.destroy', $actuality))
            ->assertRedirect(route('actualities.index'))
            ->assertSessionHas('success', 'Actualité supprimée avec succès.');

        $this->assertSoftDeleted('actualities', ['id' => $actuality->id]);
    }

    /**
     * Test that access is forbidden to destroy an actuality when user does not have access.
     */
    public function test_forbids_access_to_destroy_an_actuality_when_user_does_not_have_access()
    {
        $actuality = Actuality::factory()->create();
        $user = User::factory()->create([
            'role' => 'admin'
        ]); // Different organization

        $this->partialMock(UserHelper::class, function ($mock) {
            $mock->shouldReceive('isAdministrator')->andReturn(true);
        });

        $this->actingAs($user)
            ->delete(route('actualities.destroy', $actuality))
            ->assertStatus(403);

        $this->assertDatabaseHas('actualities', ['id' => $actuality->id]);
    }
}
