<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    public Ticket $ticket;
    public string $subject = '';
    public string $description = '';
    public string $status = 'open';

    protected $rules = [
        'subject' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:open,closed',
    ];

    protected $validationAttributes = [
        'subject' => 'sujet',
        'description' => 'description',
        'status' => 'statut',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->subject = $ticket->subject;
        $this->description = $ticket->description;
        $this->status = $ticket->status;
    }

    public function updateTicket()
    {
        $this->validate();

        $this->ticket->update([
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('ticketUpdated');

        return redirect()->route('tickets.show', $this->ticket)
            ->with('message', 'Ticket mis à jour avec succès.');
    }

    public function render(): View
    {
        return view('livewire.tickets.edit');
    }
}
