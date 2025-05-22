<?php

namespace App\Livewire\Actualities;

use App\Models\Actuality;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    public Actuality $actuality;

    public function mount(Actuality $actuality): void
    {
        $this->actuality = $actuality;
    }

    public function deleteActuality(): void
    {
        $this->actuality->delete();

        $this->modal('delete-actuality-' . $this->actuality->id)->close();

        $this->dispatch('actualityDeleted');

        session()->flash('success', 'Actualité supprimée avec succès.');

        redirect()->route('actualities.index');
    }

    public function render(): View
    {
        return view('livewire.actualities.delete');
    }
}
