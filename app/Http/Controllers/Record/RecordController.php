<?php

namespace App\Http\Controllers\Record;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    /**
     *
     */
    public function record_current_time(Request $request){
        dd($request->all());
        if ((Gate::allows('admin'))) {
            return view('admin.history.personal_history');
        } else {
            return view('collaborator.history.personal_history');
        }
    }
}
