<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class SearchBar extends Component
{
    public string $model;
    public string $width;

    /**
     * @param string $model
     * @param string $width
     * @return void
     */
    public function mount(string $model, string $width): void
    {
        $this->model = $model;
        $this->width = $width;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.search-bar');
    }

    /**
     * @return void
     */
    public function updated(): void
    {
        $this->dispatch('searchUpdated', $this->model);
    }

}
