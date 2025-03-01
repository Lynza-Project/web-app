<?php

namespace App\Policies;

use App\Models\Actuality;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActualityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Actuality $actuality): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Actuality $actuality): bool
    {
    }

    public function delete(User $user, Actuality $actuality): bool
    {
    }

    public function restore(User $user, Actuality $actuality): bool
    {
    }

    public function forceDelete(User $user, Actuality $actuality): bool
    {
    }
}
