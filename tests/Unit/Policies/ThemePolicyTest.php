<?php

namespace Tests\Unit\Policies;

use App\Models\Theme;
use App\Models\Organization;
use App\Models\User;
use App\Policies\ThemePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemePolicyTest extends TestCase
{
    use RefreshDatabase;

    private ThemePolicy $policy;
    private Organization $organization1;
    private Organization $organization2;
    private User $superAdmin;
    private User $admin;
    private User $user;
    private Theme $theme;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new ThemePolicy();

        $this->organization1 = Organization::factory()->create();
        $this->organization2 = Organization::factory()->create();

        $this->superAdmin = User::factory()->create([
            'role' => 'super-admin',
            'organization_id' => $this->organization1->id,
        ]);

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization1->id,
        ]);

        $this->user = User::factory()->create([
            'role' => 'user',
            'organization_id' => $this->organization1->id,
        ]);

        $this->theme = Theme::factory()->create([
            'organization_id' => $this->organization1->id,
        ]);
    }

    public function test_view_any_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->viewAny($this->superAdmin));
    }

    public function test_view_any_returns_false_for_non_super_admin()
    {
        $this->assertFalse($this->policy->viewAny($this->admin));
        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_view_returns_true_for_user_in_same_organization()
    {
        $this->assertTrue($this->policy->view($this->user, $this->theme));
    }

    public function test_view_returns_false_for_user_in_different_organization()
    {
        $userFromOtherOrg = User::factory()->create([
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->view($userFromOtherOrg, $this->theme));
    }

    public function test_create_returns_true_for_admin_and_super_admin()
    {
        $this->assertTrue($this->policy->create($this->admin));
        $this->assertTrue($this->policy->create($this->superAdmin));
    }

    public function test_create_returns_false_for_regular_user()
    {
        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_update_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->update($this->superAdmin, $this->theme));
    }

    public function test_update_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->update($this->admin, $this->theme));
    }

    public function test_update_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->update($adminFromOtherOrg, $this->theme));
    }

    public function test_update_returns_false_for_regular_user()
    {
        $this->assertFalse($this->policy->update($this->user, $this->theme));
    }

    public function test_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->delete($this->superAdmin, $this->theme));
    }

    public function test_delete_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->delete($this->admin, $this->theme));
    }

    public function test_delete_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->delete($adminFromOtherOrg, $this->theme));
    }

    public function test_delete_returns_false_for_regular_user()
    {
        $this->assertFalse($this->policy->delete($this->user, $this->theme));
    }

    public function test_restore_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->restore($this->superAdmin));
    }

    public function test_restore_returns_false_for_admin_and_regular_user()
    {
        $this->assertFalse($this->policy->restore($this->admin));
        $this->assertFalse($this->policy->restore($this->user));
    }

    public function test_force_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->forceDelete($this->superAdmin));
    }

    public function test_force_delete_returns_false_for_admin_and_regular_user()
    {
        $this->assertFalse($this->policy->forceDelete($this->admin));
        $this->assertFalse($this->policy->forceDelete($this->user));
    }
}
