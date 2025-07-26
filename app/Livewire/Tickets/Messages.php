<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\View\View;
use Livewire\Component;

class Messages extends Component
{
    public Ticket $ticket;
    public string $content = '';

    protected $rules = [
        'content' => 'required|string',
    ];

    protected $validationAttributes = [
        'content' => 'message',
    ];

    protected $listeners = ['ticketMessageAdded' => '$refresh'];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function addMessage()
    {
        $this->validate();

        TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->id(),
            'organization_id' => $this->ticket->organization_id,
            'content' => $this->content,
        ]);

        $this->reset('content');
        $this->dispatch('ticketMessageAdded');
    }

    public function deleteMessage(TicketMessage $message)
    {
        if (!$this->canManageMessage($message)) {
            return $this->addError('message', 'Vous n\'avez pas les droits pour supprimer ce message.');
        }

        $message->delete();
        $this->dispatch('ticketMessageAdded');
    }

    public function canManageMessage(TicketMessage $message): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        if ($user->role === 'admin' && $user->organization_id === $message->organization_id) {
            return true;
        }

        return $user->id === $message->user_id;
    }

    public function render(): View
    {
        return view('livewire.tickets.messages', [
            'messages' => $this->ticket->ticketMessages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get(),
        ]);
    }
}
