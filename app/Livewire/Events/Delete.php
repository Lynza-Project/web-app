<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function deleteEvent(): void
    {
        $this->event->delete();

        self::modal('delete-event-' . $this->event->id)->close();

        $this->dispatch('eventDeleted');

        session()->flash('success', 'Événement supprimé avec succès.');

        redirect()->route('events.index');
    }

    public function render(): View
    {
        return view('livewire.events.delete');
    }
}
