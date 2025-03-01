<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Organization $organization): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Organization $organization): bool
    {
    }

    public function delete(User $user, Organization $organization): bool
    {
    }

    public function restore(User $user, Organization $organization): bool
    {
    }

    public function forceDelete(User $user, Organization $organization): bool
    {
    }
}
