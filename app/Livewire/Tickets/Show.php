<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public Ticket $ticket;
    public string $status;

    protected $rules = [
        'status' => 'required|in:open,closed',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->status = $ticket->status;
    }

    public function updateStatus()
    {
        if (!$this->canManageTicket()) {
            return $this->addError('status', 'Vous n\'avez pas les droits pour modifier ce ticket.');
        }

        $this->ticket->update([
            'status' => 'closed',
        ]);

        $this->dispatch('ticketStatusUpdated');

        session()->flash('message', 'Ticket cloturé avec succès.');

        return redirect()->route('tickets.index');
    }

    public function canManageTicket(): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        if ($user->role === 'admin' && $user->organization_id === $this->ticket->organization_id) {
            return true;
        }

        return $user->id === $this->ticket->user_id;
    }

    public function render(): View
    {
        return view('livewire.tickets.show', [
            'ticket' => $this->ticket->load(['user', 'organization', 'ticketMessages' => function ($query) {
                $query->with('user')->orderBy('created_at', 'asc');
            }]),
            'canManage' => $this->canManageTicket(),
        ]);
    }
}
