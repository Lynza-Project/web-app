<?php

namespace App\Livewire\Documentations;

use App\Models\Documentation;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    public Documentation $documentation;

    public function mount(Documentation $documentation): void
    {
        $this->documentation = $documentation;
    }

    public function deleteDocumentation(): void
    {
        $this->documentation->delete();

        self::modal('delete-documentation-' . $this->documentation->id)->close();

        $this->dispatch('documentationDeleted');

        session()->flash('success', 'Documentation supprimée avec succès.');

        redirect()->route('documentations.index');
    }

    public function render(): View
    {
        return view('livewire.documentations.delete');
    }
}
