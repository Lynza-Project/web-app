<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!UserHelper::isAdministrator()) {
                abort(403, 'Vous n\'avez pas accès à cette page.');
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('events.index');
    }

    /**
     * @param Event $event
     * @return View
     */
    public function show(Event $event): View
    {
        if (!$this->userCanAccessEvent($event)) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        return view('events.show', [
            'event' => $event,
        ]);
    }

    /**
     * @param Event $event
     * @return View
     */
    public function edit(Event $event): View
    {
        if (!$this->userCanAccessEvent($event)) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        return view('events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * @param Event $event
     * @return RedirectResponse
     */
    public function update(Event $event): RedirectResponse
    {
        if (!$this->userCanAccessEvent($event)) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        return redirect()->route('events.show', $event)
            ->with('success', 'Événement mis à jour avec succès.');
    }

    /**
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        if (!$this->userCanAccessEvent($event)) {
            abort(403, 'Vous n\'avez pas accès à cet événement.');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Événement supprimé avec succès.');
    }

    /**
     * @param Event $event
     * @return bool
     */
    private function userCanAccessEvent(Event $event): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        return $user->organization_id === $event->organization_id;
    }
}
