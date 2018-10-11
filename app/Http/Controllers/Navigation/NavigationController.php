<?php

namespace App\Http\Controllers\Navigation;

use App\Models\Historic;
use App\Models\Record;
use App\User;
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
    private $total_page = 10;

    /**
     *  This method verify access level and redirect for respective dashboard page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Record $record)
    {
        if ((Gate::allows('admin'))) {
            return view('admin.home.index');
        } else {
            $records = auth()->user()->records()->paginate($this->total_page);

            $types = $record->getAllTypes();
            return view('collaborator.home.index', compact('records', 'types'));
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
            $users = Auth::user()->all()->where('is_admin', 0);
            return view('admin.records.employee_record', compact('users'));
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

        $record_formated = auth()->user()->historic_formated();
        return view('users.history.personal_history', compact('record_formated'));
    }

    /**
     * This method check user logged and redirect for view if is admin user
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function record_employee_view(Request $request, User $user)
    {
        if ((Gate::allows('admin'))) {
            $user = $user->get_by_id($request['user_id']);

            return view('admin.records.insert_hour_for_employee', compact('user'));
        }

    }


}
