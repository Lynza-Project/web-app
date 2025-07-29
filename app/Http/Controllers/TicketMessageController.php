<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    /**
     * Store a newly created ticket message in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        if (!$this->userCanAccessTicket($ticket)) {
            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'organization_id' => $ticket->organization_id,
            'content' => $validated['content'],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('message', 'Message ajouté avec succès.');
    }

    /**
     * Update the specified ticket message in storage.
     *
     * @param Request $request
     * @param TicketMessage $ticketMessage
     * @return RedirectResponse
     */
    public function update(Request $request, TicketMessage $ticketMessage): RedirectResponse
    {
        if (!$this->userCanAccessTicketMessage($ticketMessage)) {
            abort(403, 'Vous n\'avez pas accès à ce message.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $ticketMessage->update([
            'content' => $validated['content'],
        ]);

        return redirect()->route('tickets.show', $ticketMessage->ticket)
            ->with('message', 'Message mis à jour avec succès.');
    }

    /**
     * Remove the specified ticket message from storage.
     *
     * @param TicketMessage $ticketMessage
     * @return RedirectResponse
     */
    public function destroy(TicketMessage $ticketMessage): RedirectResponse
    {
        if (!$this->userCanAccessTicketMessage($ticketMessage)) {
            abort(403, 'Vous n\'avez pas accès à ce message.');
        }

        $ticket = $ticketMessage->ticket;
        $ticketMessage->delete();

        return redirect()->route('tickets.show', $ticket)
            ->with('message', 'Message supprimé avec succès.');
    }

    /**
     * Determine if the user can access the ticket.
     *
     * @param Ticket $ticket
     * @return bool
     */
    private function userCanAccessTicket(Ticket $ticket): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        if ($user->role === 'admin' && $user->organization_id === $ticket->organization_id) {
            return true;
        }

        return $user->id === $ticket->user_id;
    }

    /**
     * Determine if the user can access the ticket message.
     *
     * @param TicketMessage $ticketMessage
     * @return bool
     */
    private function userCanAccessTicketMessage(TicketMessage $ticketMessage): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        if ($user->role === 'admin' && $user->organization_id === $ticketMessage->organization_id) {
            return true;
        }

        return $user->id === $ticketMessage->user_id;
    }
}
