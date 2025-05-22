<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Update extends Component
{
    public User $user;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $role;

    /**
     * @var string[]
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $validationAttributes = [
        'first_name' => 'prénom',
        'last_name' => 'nom',
        'email' => 'adresse e-mail',
        'role' => 'role',
    ];

    /**
     * @param User $user
     * @return void
     */
    public function mount(User $user): void
    {
        $this->user = $user;
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
    }

    /**
     * @return void
     */
    public function submit(): void
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->modal('update-user-' . $this->user->id)->close();

        $this->dispatch('userUpdated');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.users.update');
    }
}
