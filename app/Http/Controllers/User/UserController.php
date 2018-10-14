<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * This method search users if you are an administrator
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_user(Request $request, User $user){
        if ((Gate::allows('admin'))) {
            $data_form = $request->except('_token');
            $users = $user->search_user($data_form)->get();
            $action = $data_form['action'];
            return view('admin.records.employee_record', compact('users', 'action'));
        } else {
            return redirect()->route('navigation.home');
        }
    }
}
