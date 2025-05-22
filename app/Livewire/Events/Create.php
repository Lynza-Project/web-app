<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $location = '';
    public $date;
    public $image;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'date' => 'required|date',
        'location' => 'required',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'description' => 'description',
        'date' => 'date',
        'location' => 'lieu',
    ];

    public function createEvent(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'location' => $this->location,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('events/' . auth()->user()->organization_id, 'public');
        } else {
            $data['image'] = null;
        }

        Event::create($data);

        $this->reset(['title', 'description', 'date', 'location', 'image']);

        self::modal('create-event')->close();

        $this->dispatch('eventCreated');
    }

    public function render(): View
    {
        return view('livewire.events.create');
    }
}
