<?php

namespace Tests\Unit\Policies;

use App\Models\Documentation;
use App\Models\Organization;
use App\Models\User;
use App\Policies\DocumentationPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentationPolicyTest extends TestCase
{
    use RefreshDatabase;

    private DocumentationPolicy $policy;
    private Organization $organization1;
    private Organization $organization2;
    private User $superAdmin;
    private User $admin;
    private User $user;
    private Documentation $documentation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new DocumentationPolicy();

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

        $this->documentation = Documentation::factory()->create([
            'organization_id' => $this->organization1->id,
        ]);
    }

    public function test_view_any_returns_true_for_any_user()
    {
        $this->assertTrue($this->policy->viewAny());
    }

    public function test_view_returns_true_for_user_in_same_organization()
    {
        $this->assertTrue($this->policy->view($this->user, $this->documentation));
    }

    public function test_view_returns_false_for_user_in_different_organization()
    {
        $userFromOtherOrg = User::factory()->create([
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->view($userFromOtherOrg, $this->documentation));
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
        $this->assertTrue($this->policy->update($this->superAdmin, $this->documentation));
    }

    public function test_update_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->update($this->admin, $this->documentation));
    }

    public function test_update_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->update($adminFromOtherOrg, $this->documentation));
    }

    public function test_update_returns_false_for_regular_user()
    {
        $this->assertFalse($this->policy->update($this->user, $this->documentation));
    }

    public function test_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->delete($this->superAdmin, $this->documentation));
    }

    public function test_delete_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->delete($this->admin, $this->documentation));
    }

    public function test_delete_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->delete($adminFromOtherOrg, $this->documentation));
    }

    public function test_delete_returns_false_for_regular_user()
    {
        $this->assertFalse($this->policy->delete($this->user, $this->documentation));
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
