<?php

namespace App\Policies;

use App\Models\LostAndFound;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LostAndFoundPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LostAndFound $lostAndFound): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LostAndFound $lostAndFound): bool
    {
    }

    public function delete(User $user, LostAndFound $lostAndFound): bool
    {
    }

    public function restore(User $user, LostAndFound $lostAndFound): bool
    {
    }

    public function forceDelete(User $user, LostAndFound $lostAndFound): bool
    {
    }
}
