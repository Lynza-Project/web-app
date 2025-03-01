<?php

namespace App\Policies;

use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketMessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, TicketMessage $ticketMessage): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, TicketMessage $ticketMessage): bool
    {
    }

    public function delete(User $user, TicketMessage $ticketMessage): bool
    {
    }

    public function restore(User $user, TicketMessage $ticketMessage): bool
    {
    }

    public function forceDelete(User $user, TicketMessage $ticketMessage): bool
    {
    }
}
