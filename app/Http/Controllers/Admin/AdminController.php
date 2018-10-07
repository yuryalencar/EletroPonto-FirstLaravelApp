<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && (Gate::allows('admin'))) {
            return view('admin.home.index');
        } else if (Auth::check()){
            return redirect()->route('collaborator.home');
        } else {
            return redirect()->route('login');
        }
    }
}
