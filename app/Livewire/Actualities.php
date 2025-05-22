<?php

namespace App\Livewire;

use App\Models\Actuality;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Actualities extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public bool $canDelete = false;

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
        $actualities = Actuality::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(6);

        return view('livewire.actualities', compact('actualities'));
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

    #[On('actualityCreated')]
    public function actualityCreated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('actualityEdited')]
    public function actualityEdited(): void
    {
        $this->dispatch('refresh');
    }

    #[On('actualityDeleted')]
    public function actualityDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
