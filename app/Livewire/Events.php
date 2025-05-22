<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'start_date';
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
        $events = Event::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(6);

        return view('livewire.events', compact('events'));
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

    #[On('eventCreated')]
    public function eventCreated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('eventEdited')]
    public function eventEdited(): void
    {
        $this->dispatch('refresh');
    }

    #[On('eventDeleted')]
    public function eventDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
