<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('users.index');
    }
}
