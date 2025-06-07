<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    /**
     * @param User $user
     * @return void
     */
    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return void
     */
    public function deleteUser(): void
    {
        $user = User::findOrFail($this->user->id);
        $user->delete();

        $this->modal('delete-user-' . $this->user->id)->close();
        $this->dispatch('userDeleted');
    }

    public function render(): View
    {
        return view('livewire.users.delete');
    }
}
