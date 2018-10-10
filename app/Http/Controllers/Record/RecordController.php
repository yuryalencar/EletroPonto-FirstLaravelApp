<?php

namespace App\Http\Controllers\Record;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Historic;
use Carbon\Carbon;

class RecordController extends Controller
{

    private $total_page = 10;

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
