<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Actuality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActualityController extends Controller
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
        return view('actualities.index');
    }

    /**
     * @param Actuality $actuality
     * @return View
     */
    public function show(Actuality $actuality): View
    {
        if (!$this->userCanAccessActuality($actuality)) {
            abort(403, 'Vous n\'avez pas accès à cette actualité.');
        }

        return view('actualities.show', [
            'actuality' => $actuality,
        ]);
    }

    /**
     * @param Actuality $actuality
     * @return View
     */
    public function edit(Actuality $actuality): View
    {
        if (!$this->userCanAccessActuality($actuality)) {
            abort(403, 'Vous n\'avez pas accès à cette actualité.');
        }

        return view('actualities.edit', [
            'actuality' => $actuality,
        ]);
    }

    /**
     * @param Actuality $actuality
     * @return RedirectResponse
     */
    public function update(Actuality $actuality): RedirectResponse
    {
        if (!$this->userCanAccessActuality($actuality)) {
            abort(403, 'Vous n\'avez pas accès à cette actualité.');
        }

        return redirect()->route('actualities.show', $actuality)
            ->with('success', 'Actualité mise à jour avec succès.');
    }

    /**
     * @param Actuality $actuality
     * @return RedirectResponse
     */
    public function destroy(Actuality $actuality): RedirectResponse
    {
        if (!$this->userCanAccessActuality($actuality)) {
            abort(403, 'Vous n\'avez pas accès à cette actualité.');
        }

        $actuality->delete();

        return redirect()->route('actualities.index')
            ->with('success', 'Actualité supprimée avec succès.');
    }

    /**
     * @param Actuality $actuality
     * @return bool
     */
    private function userCanAccessActuality(Actuality $actuality): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        return $user->organization_id === $actuality->organization_id;
    }
}
