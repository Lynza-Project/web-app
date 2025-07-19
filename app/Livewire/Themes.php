<?php

namespace App\Livewire;

use App\Models\Theme;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Themes extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public bool $canManage = false;

    public function mount(): void
    {
        $this->canManage = in_array(auth()->user()->role, ['super-admin', 'admin']);
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
        $themes = Theme::query()
            ->where('organization_id', auth()->user()->organization_id)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('primary', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(6);

        $theme = Theme::where('organization_id', auth()->user()->organization_id)->first();

        return view('livewire.themes', compact('themes', 'theme'));
    }

    /*** Useful functions ***/

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

    #[On('themeCreated')]
    public function themeCreated(): void
    {
        $this->dispatch('refresh');
    }

    #[On('themeEdited')]
    public function themeEdited(): void
    {
        $this->dispatch('refresh');
    }

    #[On('themeDeleted')]
    public function themeDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
