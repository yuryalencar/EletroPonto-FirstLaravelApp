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
            $request->session()->flash("error_insert_data", "Horário inválido, por favor verifique o horário informado");
            return view('admin.records.insert_hour_for_employee', compact('user'));
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
        $historic = $record->get_record_by_id($data_form['id_record'])->first()->historics();

        $historic = $historic->paginate($this->total_page);
        return view('users.history.record_history', compact('historic'));
    }

    public function records_employee(Request $request, User $user, Record $example_record){
        if ((Gate::allows('admin'))) {
            $user = $user->get_by_id($request['user_id']);
            $records = $user->records()->paginate($this->total_page);
            $types = $example_record->getAllTypes();
            return view('collaborator.home.index', compact('records', 'types', 'user'));
        } else {
            return redirect()->route('navigation.home');
        }
    }

    public function  detailed_records_employee(Request $request, Record $record){
        if ((Gate::allows('admin'))) {
            dd($request);
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
