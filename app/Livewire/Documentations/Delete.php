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

        $this->dispatch('documentationDeleted');
    }

    public function render(): View
    {
        return view('livewire.documentations.delete');
    }
}
