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

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public bool $canManage = false;

    public function mount(): void
    {
        $this->canManage = in_array(auth()->user()->role, ['super-admin', 'admin']);
    }

    /**
     * Sort themes by the specified field
     *
     * @param string $field The field to sort by
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
     * Render the themes component
     *
     * @return View The view with themes data
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

    // Event handlers and search functionality

    /**
     * Handle search updates from external components
     *
     * @param mixed $search The search term
     * @return void
     */
    #[On('searchUpdated')]
    public function searchUpdated($search): void
    {
        $this->search = is_array($search) ? $search[0] : $search;
        $this->resetPage();
    }

    /**
     * Reset pagination when search term is updated
     *
     * @return void
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Handle theme creation event
     *
     * @return void
     */
    #[On('themeCreated')]
    public function themeCreated(): void
    {
        $this->dispatch('refresh');
    }

    /**
     * Handle theme edit event
     *
     * @return void
     */
    #[On('themeEdited')]
    public function themeEdited(): void
    {
        $this->dispatch('refresh');
    }

    /**
     * Handle theme deletion event
     *
     * @return void
     */
    #[On('themeDeleted')]
    public function themeDeleted(): void
    {
        $this->dispatch('refresh');
    }
}
