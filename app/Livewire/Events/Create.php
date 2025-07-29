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
    public $start_date;
    public $end_date = null;
    public $start_time = null;
    public $end_time = null;
    public $image;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'start_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after:start_time',
        'location' => 'required',
    ];

    protected $validationAttributes = [
        'title' => 'titre',
        'description' => 'description',
        'start_date' => 'date de début',
        'end_date' => 'date de fin',
        'start_time' => 'heure de début',
        'end_time' => 'heure de fin',
        'location' => 'lieu',
    ];

    public function createEvent()
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
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('events/' . auth()->user()->organization_id . '/logos', 's3');
        } else {
            $data['image'] = null;
        }

        $event = Event::create($data);

        $this->reset(['title', 'description', 'start_date', 'end_date', 'start_time', 'end_time', 'location', 'image']);

        $this->dispatch('eventCreated');

        return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
    }

    public function render(): View
    {
        return view('livewire.events.create');
    }
}
