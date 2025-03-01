<?php

namespace App\Policies;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Theme $theme): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Theme $theme): bool
    {
    }

    public function delete(User $user, Theme $theme): bool
    {
    }

    public function restore(User $user, Theme $theme): bool
    {
    }

    public function forceDelete(User $user, Theme $theme): bool
    {
    }
}
