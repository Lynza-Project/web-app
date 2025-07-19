<?php

namespace App\Livewire\Themes;

use App\Models\Theme;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $primary = '';
    public string $font = '';
    public string $background_color = '';
    public string $button_color = '';
    public $logo = null;

    protected $rules = [
        'title' => 'required',
        'primary' => 'required',
        'font' => 'required',
        'background_color' => 'nullable',
        'button_color' => 'nullable',
        'logo' => 'nullable|image|max:1024',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'primary' => 'couleur primaire',
        'font' => 'police',
        'background_color' => 'couleur de fond',
        'button_color' => 'couleur de bouton',
        'logo' => 'logo',
    ];

    /**
     * Create a new theme for the organization
     *
     * @return void
     */
    public function createTheme(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'primary' => $this->primary,
            'font' => $this->font,
            'background_color' => $this->background_color,
            'button_color' => $this->button_color,
            'organization_id' => auth()->user()->organization_id,
        ];

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('themes/' . auth()->user()->organization_id . '/logos', 's3');
        }

        Theme::create($data);

        $this->reset([
            'title', 'primary', 'font', 'background_color',
            'button_color', 'logo'
        ]);

        self::modal('create-theme')->close();

        $this->dispatch('themeCreated');
    }

    /**
     * Render the theme creation form
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.themes.create');
    }
}
