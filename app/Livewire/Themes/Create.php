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
    public string $danger = '';
    public string $gray = '';
    public string $info = '';
    public string $success = '';
    public string $warning = '';
    public string $font = '';
    public string $background_color = '';
    public string $text_color = '';
    public string $button_color = '';
    public $logo;

    protected $rules = [
        'title' => 'required',
        'primary' => 'required',
        'danger' => 'required',
        'gray' => 'required',
        'info' => 'required',
        'success' => 'required',
        'warning' => 'required',
        'font' => 'required',
        'background_color' => 'nullable',
        'text_color' => 'nullable',
        'button_color' => 'nullable',
        'logo' => 'nullable|image|max:1024',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'primary' => 'couleur primaire',
        'danger' => 'couleur danger',
        'gray' => 'couleur grise',
        'info' => 'couleur info',
        'success' => 'couleur succès',
        'warning' => 'couleur avertissement',
        'font' => 'police',
        'background_color' => 'couleur de fond',
        'text_color' => 'couleur de texte',
        'button_color' => 'couleur de bouton',
        'logo' => 'logo',
    ];

    public function createTheme(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'primary' => $this->primary,
            'danger' => $this->danger,
            'gray' => $this->gray,
            'info' => $this->info,
            'success' => $this->success,
            'warning' => $this->warning,
            'font' => $this->font,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
            'button_color' => $this->button_color,
            'organization_id' => auth()->user()->organization_id,
        ];

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('themes/' . auth()->user()->organization_id . '/logos', 's3');
        }

        Theme::create($data);

        $this->reset([
            'title', 'primary', 'danger', 'gray', 'info', 'success',
            'warning', 'font', 'background_color', 'text_color',
            'button_color', 'logo'
        ]);

        self::modal('create-theme')->close();

        $this->dispatch('themeCreated');
    }

    public function render(): View
    {
        return view('livewire.themes.create');
    }
}
