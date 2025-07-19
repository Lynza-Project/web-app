<?php

namespace App\Livewire\Themes;

use App\Models\Theme;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    public Theme $theme;

    public function mount(Theme $theme): void
    {
        $this->theme = $theme;
    }

    public function deleteTheme(): void
    {
        $this->theme->delete();

        self::modal('delete-theme-' . $this->theme->id)->close();

        $this->dispatch('themeDeleted');

        session()->flash('success', 'Thème supprimé avec succès.');

        redirect()->route('themes.index');
    }

    public function render(): View
    {
        return view('livewire.themes.delete');
    }
}
