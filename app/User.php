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

    /**
     * This method create a relationship between user and record
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * This method create a relationship between user and historic
     */
    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    /**
     * This method search user by id
     * @param $id
     * @return mixed
     */
    public function get_by_id($id)
    {
        $user = $this->where('id', $id);

        return $user->first();
    }

    /**
     * This method create a template array for detailed historic
     * @param $amount
     * @return array
     */
    private function create_template_array($amount)
    {
        $record_formated = array();
        for ($i = 0; $i < $amount / 4; $i++) {
            array_push($record_formated, [
                'date' => "",
                'entry' => "",
                'break_work' => "",
                'return_work' => "",
                'leave_work' => "",
                'total_hours' => 0,
            ]);
        }

        return $record_formated;
    }

    /**
     * This method create a detailed historic formated
     * @return array
     */
    public function historic_formated()
    {
        $records = $this->records()->get();

        $record_formated = $this->create_template_array(ceil(sizeof($records)));

        // For create a format historic
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

    /**
     * This method search in detailed historic
     * @param array $data
     * @return array
     */
    public function search_historic_formated(Array $data)
    {
        if (!(isset($data['date'])) or $data['date'] == "") {
            return $this->historic_formated();
        }

        $records = $this->records()->get();

        $record_formated = $this->create_template_array(ceil(sizeof($records)));

        // For create a format historic
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

        $filter_record = array();
        $index = 0;
        foreach ($record_formated as $record) {
            if (Carbon::parse($data['date'])->format('d/m/Y') == $record['date']) {
                $filter_record[$index] = $record;
                $index++;
            }
        }

        $filter_record = $this->format_data($filter_record);
        return $filter_record;

    }

    /**
     * This method format a array for detailed historic
     * @param $record
     * @return mixed
     */
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

    /**
     * This method verify if is admin user
     * @return bool
     */
    public function isAdmin()
    {
        return Auth::user()->is_admin == 1;
    }

    /**
     * This method search user using various parameters
     * @param array $data
     * @return mixed
     */
    public function search_user(Array $data)
    {
        $users = $this->where(function ($query) use ($data) {
            if (isset($data['id']))
                $query->where('id', $data['id']);
            if (isset($data['name']))
                $query->where('name', '>', $data['name']);
            if (isset($data['email']))
                $query->where('email', $data['email']);
        })->where('is_admin', 0);

        return $users;
    }
}
