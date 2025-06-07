<?php

namespace App\Livewire\Users;

use App\Models\User;
use Hash;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $role = 'user';

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
    ];

    protected $validationAttributes = [
        'first_name' => 'prénom',
        'last_name' => 'nom',
        'email' => 'email',
        'role' => 'role',
    ];

    public function createUser(): void
    {
        $this->validate();

        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'organization_id' => auth()->user()->organization_id,
            'password' => Hash::make('password'),
        ]);

        $this->reset(['first_name', 'last_name', 'email', 'role']);

        $this->modal('create-user')->close();

        $this->dispatch('userCreated');
    }

    public function render(): View
    {
        return view('livewire.users.create');
    }
}

