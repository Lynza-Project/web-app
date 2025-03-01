<?php

namespace App\Policies;

use App\Models\Actuality;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActualityPolicy
{
    use HandlesAuthorization;


    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Actuality $actuality): bool
    {
        return $user->organization_id === $actuality->organization_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'super-admin']);
    }

    public function update(User $user, Actuality $actuality): bool
    {
        return $user->role === 'super-admin' || ($user->role === 'admin' && $user->organization_id === $actuality->organization_id);
    }

    public function delete(User $user, Actuality $actuality): bool
    {
        return $user->role === 'super-admin' || ($user->role === 'admin' && $user->organization_id === $actuality->organization_id);
    }

    public function restore(User $user): bool
    {
        return $user->role === 'super-admin';
    }

    public function forceDelete(User $user): bool
    {
        return $user->role === 'super-admin';
    }
}
