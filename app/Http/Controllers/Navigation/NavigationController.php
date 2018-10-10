<?php

namespace App\Http\Controllers\Navigation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
     * This method does not need to check the level of access to redirect the respective personal time records page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personal_record()
    {
        return view('users.records.personal_record');
    }

    /**
     * This method verify access level and redirect for respective employee time records page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function employee_record()
    {
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
    public function history_employees()
    {
        if ((Gate::allows('admin'))) {
            return view('admin.history.history_employees');
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method does not need to check the level of access to redirect the respective personal time records page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function personal_history()
    {
        $records = auth()->user()->records;

        // For create a format historic
        $historic_formated = array();
        for ($i = 0; $i < ceil(sizeof($records) / 4); $i++) {
            array_push($historic_formated, [
                'date' => "",
                'entry' => "",
                'break_work' => "",
                'return_work' => "",
                'leave_work' => "",
                'total_hours' => 0,
            ]);
        }
        
        $index = 0;
        for ($i = 0; $i < sizeof($records); $i++) {
            switch ($records[$i]['type']) {
                case 'I':
                    $historic_formated[$index]['date'] = date('d/m/Y', strtotime($records[$i]->business_hours));
                    $newCarbon = new Carbon($records[$i]->business_hours);
                    $historic_formated[$index]['entry'] = $newCarbon;
                    break;
                case 'II':
                    $newCarbon = new Carbon($records[$i]->business_hours);
                    $historic_formated[$index]['break_work'] = $newCarbon;

                    $newCarbonDif = new Carbon($historic_formated[$index]['entry']);
                    $historic_formated[$index]['total_hours'] = $newCarbonDif->diffInHours($newCarbon);
                    break;
                case 'OI':
                    $newCarbon = new Carbon($records[$i]->business_hours);

                    $historic_formated[$index]['return_work'] = $newCarbon;
                    break;
                case 'O':
                    $newCarbon = new Carbon($records[$i]->business_hours);

                    $historic_formated[$index]['leave_work'] = $newCarbon;

                    $historic_formated[$index]['total_hours'] = 10;
                    $index++;
                    break;
            }
        }
        //dd($historic_formated);

        return view('users.history.personal_history', compact('historic_formated'));
    }

}
