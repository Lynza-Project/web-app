<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct()
    {
        // All authenticated users can access tickets
    }

    /**
     * Display a listing of the tickets.
     *
     * @return View
     */
    public function index(): View
    {
        return view('tickets.index');
    }

    /**
     * Show the form for creating a new ticket.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tickets.create');
    }

    /**
     * Display the specified ticket.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function show(Ticket $ticket): View
    {
        if (!$this->userCanAccessTicket($ticket)) {
            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified ticket.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function edit(Ticket $ticket): View
    {
        if (!$this->userCanAccessTicket($ticket)) {
            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        return view('tickets.edit', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified ticket in storage.
     *
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function update(Ticket $ticket): RedirectResponse
    {
        if (!$this->userCanAccessTicket($ticket)) {
            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('message', 'Ticket mis à jour avec succès.');
    }

    /**
     * Remove the specified ticket from storage.
     *
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        if (!$this->userCanAccessTicket($ticket)) {
            abort(403, 'Vous n\'avez pas accès à ce ticket.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('message', 'Ticket supprimé avec succès.');
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
}
