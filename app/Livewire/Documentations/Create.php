<?php

namespace App\Livewire\Documentations;

use App\Models\Documentation;
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
        'image' => 'nullable|image|max:1024',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'content' => 'contenu',
        'image' => 'image',
    ];

    public function createDocumentation()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('documentations/' . auth()->user()->organization_id, 'public');
        } else {
            $data['image'] = null;
        }

        $documentation = Documentation::create($data);

        $this->reset(['title', 'content', 'image']);

        $this->dispatch('documentationCreated');

        return redirect()->route('documentations.index')->with('success', 'Documentation créée avec succès.');
    }

    public function render(): View
    {
        return view('livewire.documentations.create');
    }
}
