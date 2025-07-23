<?php

namespace App\Livewire\Actualities;

use App\Models\Actuality;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $content = '';
    public $image;

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'content' => 'contenu',
    ];

    public function createActuality()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('actualities/' . auth()->user()->organization_id, 'public');
        } else {
            $data['image'] = null;
        }

        $actuality = Actuality::create($data);

        $this->reset(['title', 'content', 'image']);

        $this->dispatch('actualityCreated');

        return redirect()->route('actualities.index')->with('success', 'Actualité créée avec succès.');
    }

    public function render(): View
    {
        return view('livewire.actualities.create');
    }
}
