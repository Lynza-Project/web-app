<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        if (!UserHelper::isAdministrator()) {
            abort(403);
        }
        return view('users.index');
    }
}
