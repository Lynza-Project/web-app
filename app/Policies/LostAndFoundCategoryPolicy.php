<?php

namespace App\Policies;

use App\Models\LostAndFoundCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LostAndFoundCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LostAndFoundCategory $lostAndFoundCategory): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LostAndFoundCategory $lostAndFoundCategory): bool
    {
    }

    public function delete(User $user, LostAndFoundCategory $lostAndFoundCategory): bool
    {
    }

    public function restore(User $user, LostAndFoundCategory $lostAndFoundCategory): bool
    {
    }

    public function forceDelete(User $user, LostAndFoundCategory $lostAndFoundCategory): bool
    {
    }
}
