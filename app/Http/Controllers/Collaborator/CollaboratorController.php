<?php

namespace App\Http\Controllers\Collaborator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CollaboratorController extends Controller
{
    public function index()
    {
        if (Auth::check() && !(Gate::allows('admin'))) {
            return view('collaborator.home.index');
        } else if (Auth::check()){
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('login');
        }
    }
}
