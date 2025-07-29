<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
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

    public function createTicket()
    {
        $this->validate();

        $ticket = Ticket::create([
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status,
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
        ]);

        $this->reset(['subject', 'description']);
        $this->status = 'open';

        $this->dispatch('ticketCreated');

        return redirect()->route('tickets.show', $ticket)
            ->with('message', 'Ticket créé avec succès.');
    }

    public function render(): View
    {
        return view('livewire.tickets.create');
    }
}
