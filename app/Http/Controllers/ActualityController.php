<?php

namespace App\Http\Controllers;

use App\Models\Actuality;
use Illuminate\View\View;

class ActualityController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        return view('actualities.index');
    }

    /**
     * Display the specified resource.
     * @param Actuality $actuality
     * @return View
     */
    public function show(Actuality $actuality): View
    {
        return view('actualities.show', compact('actuality'));
    }
}
