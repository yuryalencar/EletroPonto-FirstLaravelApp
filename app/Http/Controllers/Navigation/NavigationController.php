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
        if ((Gate::allows('admin'))) {
            return view('admin.home.index');
        } else {
            return view('collaborator.home.index');
        }
    }

    /**
     * This method verify access level and redirect for respective personal time record page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personal_record(){
        if ((Gate::allows('admin'))) {
            return view('admin.records.personal_record');
        } else {
            return view('collaborator.records.personal_record');
        }
    }

    /**
     * This method verify access level and redirect for respective employee time record page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function employee_record(){
        if ((Gate::allows('admin'))) {
            return view('admin.records.employee_record');
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method verify access level and redirect for respective history of employees page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function history_employees(){
        if ((Gate::allows('admin'))) {
            return view('admin.history.history_employees');
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method verify access level and redirect for respective history of employees page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function personal_history(){
        if ((Gate::allows('admin'))) {
            return view('admin.history.personal_history');
        } else {
            return view('collaborator.history.personal_history');
        }
    }

}
