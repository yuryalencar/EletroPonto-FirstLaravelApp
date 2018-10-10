<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Record;
use App\Models\Historic;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function historic_formated()
    {
        $records = $this->records()->get();

        // For create a format historic
        $record_formated = array();
        for ($i = 0; $i < ceil(sizeof($records) / 4); $i++) {
            array_push($record_formated, [
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
                    $record_formated[$index]['date'] = date('d/m/Y', strtotime($records[$i]->business_hours));
                    $hour = new Carbon($records[$i]->business_hours);
                    $record_formated[$index]['entry'] = $hour;
                    break;
                case 'II':
                    $hour = new Carbon($records[$i]->business_hours);
                    $record_formated[$index]['break_work'] = $hour;

                    $hourForDif = new Carbon($record_formated[$index]['entry']);
                    $record_formated[$index]['total_hours'] = gmdate('H:i:s', $hourForDif->diffInSeconds($hour));
                    break;
                case 'OI':
                    $hour = new Carbon($records[$i]->business_hours);

                    $record_formated[$index]['return_work'] = $hour;
                    break;
                case 'O':
                    $hour = new Carbon($records[$i]->business_hours);

                    $record_formated[$index]['leave_work'] = $hour;
                    $hourForDif = new Carbon($record_formated[$index]['return_work']);
                    $seconds = $hourForDif->diffInSeconds($hour);

                    $hour = new Carbon($record_formated[$index]['entry']);
                    $hourForDif = new Carbon($record_formated[$index]['break_work']);
                    $seconds += $hourForDif->diffInSeconds($hour);

                    $record_formated[$index]['total_hours'] = gmdate('H:i:s', $seconds);

                    $index++;
                    break;
            }
        }

        $record_formated = $this->format_data($record_formated);
        return $record_formated;

    }

    private function format_data($record)
    {
        for ($i = 0; $i < sizeof($record); $i++) {
            if ($record[$i]['entry'] != "")
                $record[$i]['entry'] = $record[$i]['entry']->format('H:i:s (d/m/Y)');
            if ($record[$i]['break_work'] != "")
                $record[$i]['break_work'] = $record[$i]['break_work']->format('H:i:s (d/m/Y)');
            if ($record[$i]['return_work'] != "")
                $record[$i]['return_work'] = $record[$i]['return_work']->format('H:i:s (d/m/Y)');
            if ($record[$i]['leave_work'] != "")
                $record[$i]['leave_work'] = $record[$i]['leave_work']->format('H:i:s (d/m/Y)');
        }

        return $record;
    }

    public function isAdmin()
    {
        return Auth::user()->is_admin == 1;
    }
}
