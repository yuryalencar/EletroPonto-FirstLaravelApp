<?php

namespace App\Http\Controllers\Record;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Historic;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Gate;

class RecordController extends Controller
{

    private $total_page = 10;


    public function save_record(Request $request, Record $record){

        $record = $record->get_record_by_id($request['id_record'])->first();


        if(!isset($request['date']) or $request['date'] == ""){
            $request->session()->flash("error", "");
            return view('admin.records.edit_record_for_employee', compact('record'))->withErrors(['Data inválida, por favor verifique a data informada']);
        }

        if(!isset($request['time']) or $request['time'] == ""){
            return view('admin.records.edit_record_for_employee', compact('record'))->withErrors(['Horário inválido, por favor verifique o horário informado']);
        }

        $business_hours = new Carbon($request['date'].' '.$request['time']);
        $data_update['business_hours'] = $business_hours;
        $record->update($data_update);
        $this->register_historic($record, auth()->user());
        return view('admin.records.edit_record_for_employee', compact('record'))->with(['success', 'Registro Editado com Sucesso !']);
    }

    /**
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert_employee_record(Request $request, User $user)
    {
        $user = $user->get_by_id($request['user_id']);

        if (!(isset($request['time'])) or $request['time'] == "") {
            return view('admin.records.insert_hour_for_employee', compact('user'))->withErrors(['Horário inválido, por favor verifique o horário informado']);
        }

        $user = $user->get_by_id($request['user_id']);
        $date_time = new Carbon($request['time']);

        $record = [
            'user_id' => auth()->user()->id,
            'business_hours' => $date_time,
            'type' => $this->detect_type($user)
        ];

        $record = $user->records()->create($record);

        $this->register_historic($record, auth()->user());

        $request->session()->flash("success_insert_data", "Registro salvo com sucesso");
        return view('admin.records.insert_hour_for_employee', compact('user'));
    }

    /**
     * This function get a personal record historic
     * @param Request $request
     * @param Record $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historic_personal_record(Request $request, Record $record)
    {
        $data_form = $request->except('_token');
        $historic = $record->get_record_by_id($data_form['id_record'])->first()->historics()->get();

        //$historic = $historic->paginate($this->total_page);
        return view('users.history.record_history', compact('historic', 'data_form'));
    }

    /**
     * This method verify user and redirect for collaborators records if is admin user
     * @param Request $request
     * @param User $user
     * @param Record $example_record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function records_employee(Request $request, User $user, Record $example_record)
    {
        if ((Gate::allows('admin'))) {
            $data_form = $request->except('_token');
            $user = $user->get_by_id($request['user_id']);
            $records = $user->records()->get();//paginate($this->total_page);
            //dd($records);
            $types = $example_record->getAllTypes();
            return view('collaborator.home.index', compact('records', 'types', 'user'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method get a collaborator detailed historic for admin.
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function detailed_records_employee(Request $request, User $user)
    {
        if ((Gate::allows('admin'))) {
            $user = $user->get_by_id($request['user_id']);
            $record_formated = $user->historic_formated();
            return view('users.history.personal_history', compact('record_formated', 'user'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    /**
     * This method search a personal record set
     * @param Request $request
     * @param Record $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_personal_records(Request $request, Record $record, User $user)
    {
        $data_form = $request->except('_token');
        $records = $record->search_personal_records($data_form, $this->total_page, $request['user_id']);
        $types = $record->getAllTypes();
        $user = $user->get_by_id($request['user_id']);
        return view('collaborator.home.index', compact('records', 'types', 'user'));
    }

    /**
     * This method record in database a current time and insert in table historic a historic
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function record_current_time(Request $request)
    {
        $now = new Carbon();

        $record = [
            'user_id' => auth()->user()->id,
            'business_hours' => $now,
            'type' => $this->detect_type(auth()->user())
        ];

        $record = auth()->user()->records()->create($record);

        $this->register_historic($record, auth()->user());

        return back()->with('success_insert_personal_data', 'Registro salvo com sucesso');
    }

    /**
     * This purpose method is register historic
     * @param $record
     */
    public function register_historic(Record $record, $user)
    {

        $historic_record = [
            'user_id' => $record->attributesToArray()['user_id'],
            'record_id' => $record->attributesToArray()['id'],
            'business_hours' => $record->attributesToArray()['business_hours'],
        ];

        $user->historics()->create($historic_record);
    }

    /**
     * This method purpose is detect type of last record
     * @return string
     */
    public function detect_type($user)
    {
        $user_records = $user->records;

        if ($user_records->isEmpty()) {
            return 'I';
        }

        $user_records = collect($user_records)->sortBy('date_time')->toArray();
        $last_record_type = array_last($user_records)['type'];

        switch ($last_record_type) {
            case 'I':
                return 'II';
                break;
            case 'II':
                return 'OI';
                break;
            case 'OI':
                return 'O';
                break;
            case 'O':
                return 'I';
                break;
        }
    }
}
