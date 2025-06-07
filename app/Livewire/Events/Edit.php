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
    public $start_date;
    public $end_date = null;
    public $start_time = null;
    public $end_time = null;
    public $image;
    public $newImage;

    protected function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required',
        ];
    }

    protected $validationAttributes = [
        'title' => 'titre',
        'description' => 'description',
        'start_date' => 'date de début',
        'end_date' => 'date de fin',
        'start_time' => 'heure de début',
        'end_time' => 'heure de fin',
        'location' => 'lieu',
    ];

    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->start_time = $event->start_time ? $event->start_time->format('H:i') : null;
        $this->end_time = $event->end_time ? $event->end_time->format('H:i') : null;
        $this->location = $event->location;
        $this->image = $event->image;
    }

    public function updateEvent(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
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
