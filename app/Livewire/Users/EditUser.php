<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class EditUser extends Component
{
    public string $first_name;
    public string $last_name;
    public string $role;
    public int $userId;

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'role' => 'required',
    ];

    protected $validationAttributes = [
        'first_name' => 'prénom',
        'last_name' => 'nom',
        'role' => 'role',
    ];

    /**
     * @param int $id
     * @return void
     */
    public function mount(int $id): void
    {
        $this->userId = $id;
        $user = User::findOrFail($id);
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->role = $user->role;
    }

    /**
     * @return void
     */
    public function editUser(): void
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'role' => $this->role,
        ]);

        $this->modal('edit-user-' . $this->userId)->close();

        $this->dispatch('userEdited');
    }

    public function render(): View
    {
        return view('livewire.users.edit-user');
    }
}
