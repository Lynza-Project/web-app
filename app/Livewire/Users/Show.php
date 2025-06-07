<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
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
     * @return View
     */
    public function render(): View
    {
        return view('livewire.users.show');
    }
}
