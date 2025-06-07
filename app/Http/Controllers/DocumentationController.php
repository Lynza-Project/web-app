<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Models\Documentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentationController extends Controller
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
        return view('documentations.index');
    }

    /**
     * @param Documentation $documentation
     * @return View
     */
    public function show(Documentation $documentation): View
    {
        if (!$this->userCanAccessDocumentation($documentation)) {
            abort(403, 'Vous n\'avez pas accès à cette documentation.');
        }

        return view('documentations.show', [
            'documentation' => $documentation,
        ]);
    }

    /**
     * @param Documentation $documentation
     * @return View
     */
    public function edit(Documentation $documentation): View
    {
        if (!$this->userCanAccessDocumentation($documentation)) {
            abort(403, 'Vous n\'avez pas accès à cette documentation.');
        }

        return view('documentations.edit', [
            'documentation' => $documentation,
        ]);
    }

    /**
     * @param Documentation $documentation
     * @return RedirectResponse
     */
    public function update(Documentation $documentation): RedirectResponse
    {
        if (!$this->userCanAccessDocumentation($documentation)) {
            abort(403, 'Vous n\'avez pas accès à cette documentation.');
        }

        return redirect()->route('documentations.show', $documentation)
            ->with('success', 'Documentation mise à jour avec succès.');
    }

    /**
     * @param Documentation $documentation
     * @return RedirectResponse
     */
    public function destroy(Documentation $documentation): RedirectResponse
    {
        if (!$this->userCanAccessDocumentation($documentation)) {
            abort(403, 'Vous n\'avez pas accès à cette documentation.');
        }

        $documentation->delete();

        return redirect()->route('documentations.index')
            ->with('success', 'Documentation supprimée avec succès.');
    }

    /**
     * @param Documentation $documentation
     * @return bool
     */
    private function userCanAccessDocumentation(Documentation $documentation): bool
    {
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return true;
        }

        return $user->organization_id === $documentation->organization_id;
    }
}
