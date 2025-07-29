<?php

namespace Tests\Unit\Policies;

use App\Models\LostAndFoundCategory;
use App\Models\Organization;
use App\Models\User;
use App\Policies\LostAndFoundCategoryPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LostAndFoundCategoryPolicyTest extends TestCase
{
    use RefreshDatabase;

    private LostAndFoundCategoryPolicy $policy;
    private Organization $organization1;
    private Organization $organization2;
    private User $superAdmin;
    private User $admin;
    private User $user;
    private LostAndFoundCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new LostAndFoundCategoryPolicy();

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

        $this->category = LostAndFoundCategory::factory()->create();
    }

    public function test_view_any_returns_true_for_any_user()
    {
        $this->assertTrue($this->policy->viewAny());
    }

    public function test_view_returns_true_for_any_user()
    {
        $this->assertTrue($this->policy->view());
    }

    public function test_create_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->create($this->superAdmin));
    }

    public function test_create_returns_false_for_non_super_admin()
    {
        $this->assertFalse($this->policy->create($this->admin));
        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_update_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->update($this->superAdmin));
    }

    public function test_update_returns_false_for_non_super_admin()
    {
        $this->assertFalse($this->policy->update($this->admin));
        $this->assertFalse($this->policy->update($this->user));
    }

    public function test_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->delete($this->superAdmin));
    }

    public function test_delete_returns_false_for_non_super_admin()
    {
        $this->assertFalse($this->policy->delete($this->admin));
        $this->assertFalse($this->policy->delete($this->user));
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
