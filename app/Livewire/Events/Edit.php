<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Event $event;
    public string $title = '';
    public string $description = '';
    public string $location = '';
    public $date;
    public $image;
    public $newImage;

    protected function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required',
        ];
    }

    protected $validationAttributes = [
        'title' => 'titre',
        'description' => 'description',
        'date' => 'date',
        'location' => 'lieu',
    ];

    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->date = $event->date;
        $this->location = $event->location;
        $this->image = $event->image;
    }

    public function updateEvent(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'location' => $this->location,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('events/' . auth()->user()->organization_id, 'public');
        }

        $this->event->update($data);

        session()->flash('success', 'Événement mis à jour avec succès.');

        $this->dispatch('eventEdited');

        redirect()->route('events.show', $this->event);
    }

    public function render(): View
    {
        return view('livewire.events.edit');
    }
}
