<?php

namespace App\Livewire;

use App\Models\Documentation;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Documentations extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public bool $canDelete = false;
    public int $perPage = 6;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 6],
    ];

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
        $documentations = Documentation::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.documentations', compact('documentations'));
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

    #[On('documentationCreated')]
    public function documentationCreated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('documentationEdited')]
    public function documentationEdited(): void
    {
        $this->dispatch('refresh');
    }

    #[On('documentationDeleted')]
    public function documentationDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
