<?php

namespace App\Http\Controllers\Record;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Historic;
use Carbon\Carbon;

class RecordController extends Controller
{
    /**
     * This method record in database a current time and insert in table historic a historic
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function record_current_time(Request $request){
        $now = new Carbon();

        $record = [
            'user_id' => auth()->user()->id,
            'business_hours' => $now,
            'type' => $this->detect_type()
        ];

        auth()->user()->records()->create($record);

        $user_records = auth()->user()->records;
        $user_records = collect($user_records)->sortBy('date_time')->toArray();
        $last_record = array_last($user_records);

        $this->register_historic($last_record);

        return back()->with('success', 'Record has been added');
    }

    /**
     * This purpose method is register historic
     * @param $record_array
     */
    public function register_historic($record_array){

        $historic_record2 = [
            'user_id' => $record_array['user_id'],
            'business_hours' =>  $record_array['business_hours'],
        ];

        $record_object = new Record($historic_record2);

        $historic_record = [
            'user_id' => $record_object->attributesToArray()['user_id'],
            'record_id' => $record_array['id'],
            'business_hours' =>  $record_object->attributesToArray()['business_hours'],
        ];

        auth()->user()->historics()->create($historic_record);
    }

    /**
     * This method purpose is detect type of last record
     * @return string
     */
    public function detect_type(){
        $user_records = auth()->user()->records;

        if($user_records->isEmpty()){
            return 'I';
        }

        $user_records = collect($user_records)->sortBy('date_time')->toArray();
        $last_record_type = array_last($user_records)['type'];

        switch ($last_record_type){
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
