<?php

namespace App\Livewire\Themes;

use App\Models\Theme;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Theme $theme;
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
    public $logo_path;
    public $newLogo;

    protected function rules()
    {
        return [
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
            'newLogo' => 'nullable|image|max:1024',
        ];
    }

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
        'newLogo' => 'logo',
    ];

    public function mount(Theme $theme): void
    {
        $this->theme = $theme;
        $this->title = $theme->title;
        $this->primary = $theme->primary;
        $this->danger = $theme->danger;
        $this->gray = $theme->gray;
        $this->info = $theme->info;
        $this->success = $theme->success;
        $this->warning = $theme->warning;
        $this->font = $theme->font;
        $this->background_color = $theme->background_color ?? '';
        $this->text_color = $theme->text_color ?? '';
        $this->button_color = $theme->button_color ?? '';
        $this->logo_path = $theme->logo_path;
    }

    public function updateTheme(): void
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
        ];

        if ($this->newLogo) {
            $data['logo_path'] = $this->newLogo->store('themes/' . auth()->user()->organization_id . '/logos', 's3');
        }

        $this->theme->update($data);

        session()->flash('success', 'Thème mis à jour avec succès.');

        $this->dispatch('themeEdited');

        redirect()->route('themes.index');
    }

    public function render(): View
    {
        return view('livewire.themes.edit');
    }
}
