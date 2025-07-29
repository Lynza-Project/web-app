<?php

namespace Tests\Unit\Policies;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketPolicyTest extends TestCase
{
    use RefreshDatabase;

    private TicketPolicy $policy;
    private Organization $organization1;
    private Organization $organization2;
    private User $superAdmin;
    private User $admin;
    private User $user;
    private User $otherUser;
    private Ticket $ticket;
    private Ticket $otherUserTicket;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new TicketPolicy();

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

        $this->otherUser = User::factory()->create([
            'role' => 'user',
            'organization_id' => $this->organization1->id,
        ]);

        $this->ticket = Ticket::factory()->create([
            'organization_id' => $this->organization1->id,
            'user_id' => $this->user->id,
        ]);

        $this->otherUserTicket = Ticket::factory()->create([
            'organization_id' => $this->organization1->id,
            'user_id' => $this->otherUser->id,
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

    public function test_view_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->view($this->superAdmin, $this->ticket));
    }

    public function test_view_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->view($this->admin, $this->ticket));
    }

    public function test_view_returns_true_for_ticket_owner()
    {
        $this->assertTrue($this->policy->view($this->user, $this->ticket));
    }

    public function test_view_returns_false_for_other_users()
    {
        $this->assertFalse($this->policy->view($this->otherUser, $this->ticket));
    }

    public function test_view_returns_false_for_user_in_different_organization()
    {
        $userFromOtherOrg = User::factory()->create([
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->view($userFromOtherOrg, $this->ticket));
    }

    public function test_create_returns_true_for_any_user()
    {
        $this->assertTrue($this->policy->create());
    }

    public function test_update_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->update($this->superAdmin, $this->ticket));
    }

    public function test_update_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->update($this->admin, $this->ticket));
    }

    public function test_update_returns_true_for_ticket_owner()
    {
        $this->assertTrue($this->policy->update($this->user, $this->ticket));
    }

    public function test_update_returns_false_for_other_users()
    {
        $this->assertFalse($this->policy->update($this->otherUser, $this->ticket));
    }

    public function test_update_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->update($adminFromOtherOrg, $this->ticket));
    }

    public function test_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->delete($this->superAdmin, $this->ticket));
    }

    public function test_delete_returns_true_for_admin_in_same_organization()
    {
        $this->assertTrue($this->policy->delete($this->admin, $this->ticket));
    }

    public function test_delete_returns_true_for_ticket_owner()
    {
        $this->assertTrue($this->policy->delete($this->user, $this->ticket));
    }

    public function test_delete_returns_false_for_other_users()
    {
        $this->assertFalse($this->policy->delete($this->otherUser, $this->ticket));
    }

    public function test_delete_returns_false_for_admin_in_different_organization()
    {
        $adminFromOtherOrg = User::factory()->create([
            'role' => 'admin',
            'organization_id' => $this->organization2->id,
        ]);

        $this->assertFalse($this->policy->delete($adminFromOtherOrg, $this->ticket));
    }

    public function test_restore_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->restore($this->superAdmin, $this->ticket));
    }

    public function test_restore_returns_false_for_admin_and_regular_user()
    {
        $this->assertFalse($this->policy->restore($this->admin, $this->ticket));
        $this->assertFalse($this->policy->restore($this->user, $this->ticket));
    }

    public function test_force_delete_returns_true_for_super_admin()
    {
        $this->assertTrue($this->policy->forceDelete($this->superAdmin, $this->ticket));
    }

    public function test_force_delete_returns_false_for_admin_and_regular_user()
    {
        $this->assertFalse($this->policy->forceDelete($this->admin, $this->ticket));
        $this->assertFalse($this->policy->forceDelete($this->user, $this->ticket));
    }
}
