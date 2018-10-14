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
            $user = auth()->user();
            $types = $record->getAllTypes();
            return view('collaborator.home.index', compact('records', 'types', 'user'));
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
            $action = 'insert';
            return view('admin.records.employee_record', compact('users', 'action'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method verify a permission user and presentation a choose collaborator
     * for detailed historic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view_detailed_historic_employee()
    {
        if ((Gate::allows('admin'))) {
            $users = Auth::user()->all()->where('is_admin', 0);
            dd($users);
            $action = 'detailed_historic';
            return view('admin.records.employee_record', compact('users', 'action'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method verify a permission user and presentation a choose collaborator
     * for record historic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view_record_historic_employee()
    {
        if ((Gate::allows('admin'))) {
            $users = Auth::user()->all()->where('is_admin', 0);
            $action = 'record_historic';
            return view('admin.records.employee_record', compact('users', 'action'));
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
        $user = auth()->user();
        return view('users.history.personal_history', compact('record_formated', 'user'));
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

    /**
     *  This method verify access level and redirect for respective record page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function admin_record_history(Record $record)
    {
        if ((Gate::allows('admin'))) {
            $records = auth()->user()->records()->paginate($this->total_page);
            $types = $record->getAllTypes();
            $user = auth()->user();

            return view('collaborator.home.index', compact('records', 'types', 'user'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method verify type user and redirect for edit a respective record
     * @param Request $request
     * @param Record $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_employee_record(Request $request, Record $record)
    {
        if ((Gate::allows('admin'))) {
            $record = $record->get_record_by_id($request['id_record'])->first();
            $user = auth()->user();
            return view('admin.records.edit_record_for_employee', compact('record', 'user'));
        } else {
            return redirect()->route('navigation.home');
        }

    }
}
