<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public bool $canDelete = false;
    public $perPage = 10;

    public function mount(): void
    {
        $this->canDelete = in_array(auth()->user()->role, ['super-admin', 'admin']);
    }

    /**
     * @param string $field
     * @return void
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $users = User::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.users.table', compact('users'));
    }

    /*** Fonctions utiles ***/

    #[On('searchUpdated')]
    public function searchUpdated($search): void
    {
        $this->search = is_array($search) ? $search[0] : $search;
        $this->resetPage();
    }

    /**
     * @return void
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('userCreated')]
    public function userCreated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('userUpdated')]
    public function userUpdated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('userDeleted')]
    public function userDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
