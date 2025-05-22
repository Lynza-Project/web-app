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
    public $image = null;

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'nullable|image|max:1024',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'content' => 'contenu',
        'image' => 'image',
    ];

    public function createActuality(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('actualities', 'public');
        }

        Actuality::create($data);

        $this->reset(['title', 'content', 'image']);

        $this->modal('create-actuality')->close();

        $this->dispatch('actualityCreated');
    }

    public function render(): View
    {
        return view('livewire.actualities.create');
    }
}
