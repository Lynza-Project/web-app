<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class DeleteUser extends Component
{
    public User $user;

    public function mount(int $id): void
    {
        $this->user = User::find($id);
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
        return view('livewire.users.delete-user');
    }
}
