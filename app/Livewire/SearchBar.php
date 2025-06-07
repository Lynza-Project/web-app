<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class SearchBar extends Component
{
    public string $model;

    /**
     * @param string $model
     * @return void
     */
    public function mount(string $model): void
    {
        $this->model = $model;
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
    }

}
