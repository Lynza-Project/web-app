<?php

namespace App\Livewire\Actualities;

use App\Models\Actuality;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Actuality $actuality;
    public string $title = '';
    public string $content = '';
    public $image = null;
    public $newImage = null;

    protected function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'newImage' => 'nullable|image|max:1024',
        ];
    }

    protected $validationAttributes = [
        'title' => 'titre',
        'content' => 'contenu',
        'newImage' => 'image',
    ];

    public function mount(Actuality $actuality): void
    {
        $this->actuality = $actuality;
        $this->title = $actuality->title;
        $this->content = $actuality->content;
        $this->image = $actuality->image;
    }

    public function updateActuality(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('actualities', 'public');
        }

        $this->actuality->update($data);

        session()->flash('success', 'Actualité mise à jour avec succès.');

        $this->dispatch('actualityEdited');

        redirect()->route('actualities.show', $this->actuality);
    }

    public function render(): View
    {
        return view('livewire.actualities.edit');
    }
}
