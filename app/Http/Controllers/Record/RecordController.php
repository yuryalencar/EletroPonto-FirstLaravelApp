<?php

namespace App\Http\Controllers\Record;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Historic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class RecordController extends Controller
{

    private $total_page = 10;

    public function historic_record(Request $request, Record $record){
        $data_form = $request->except('_token');
        if ((Gate::allows('admin'))) {
            dd($record->get_record_by_id($data_form['id_record']));
        } else {
            $historic = $record->get_record_by_id_and_user_id($data_form['id_record'], auth()->user()->id)->first()->historics();

            $historic = $historic->paginate($this->total_page);
            return view('users.history.record_history', compact('historic'));
        }
    }

    /**
     * This method search a personal record set
     * @param Request $request
     * @param Record $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search_personal_records(Request $request, Record $record){
        $data_form = $request->except('_token');
        $records = $record->search_personal_records($data_form, $this->total_page, auth()->user()->id);
        $types = $record->getAllTypes();

        return view('collaborator.home.index', compact('records', 'types', 'data_form'));
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
            'type' => $this->detect_type()
        ];

        $record = auth()->user()->records()->create($record);

        $this->register_historic($record);

        return back()->with('success', 'Record has been added');
    }

    /**
     * This purpose method is register historic
     * @param $record
     */
    public function register_historic(Record $record)
    {

        $historic_record = [
            'user_id' => $record->attributesToArray()['user_id'],
            'record_id' => $record->attributesToArray()['id'],
            'business_hours' => $record->attributesToArray()['business_hours'],
        ];

        auth()->user()->historics()->create($historic_record);
    }

    /**
     * This method purpose is detect type of last record
     * @return string
     */
    public function detect_type()
    {
        $user_records = auth()->user()->records;

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
