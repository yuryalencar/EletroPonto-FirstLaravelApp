<?php

namespace App\Http\Controllers\Navigation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

/**
 * Class NavigationController
 * This controller is responsible for every navigation in application
 * @package App\Http\Controllers\Navigation
 */
class NavigationController extends Controller
{
    /**
     *  This method verify access level and redirect for respective dashboard page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check() && (Gate::allows('admin'))) {
            return view('admin.home.index');
        } else if (Auth::check()){
            return view('collaborator.home.index');
        } else {
            return redirect()->route('login');
        }
    }


}
