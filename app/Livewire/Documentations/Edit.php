<?php

namespace App\Livewire\Documentations;

use App\Models\Documentation;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Documentation $documentation;
    public string $title = '';
    public string $content = '';
    public $image;
    public $newImage;

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'newImage' => 'nullable|image|max:1024',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'content' => 'contenu',
        'newImage' => 'image',
    ];

    public function mount(Documentation $documentation): void
    {
        $this->documentation = $documentation;
        $this->title = $documentation->title;
        $this->content = $documentation->content;
        $this->image = $documentation->image;
    }

    public function updateDocumentation()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('documentations/' . auth()->user()->organization_id . '/logos', 's3');
        }

        $this->documentation->update($data);

        $this->reset(['newImage']);

        $this->dispatch('documentationEdited');

        return redirect()->route('documentations.show', $this->documentation);
    }

    public function render(): View
    {
        return view('livewire.documentations.edit');
    }
}
