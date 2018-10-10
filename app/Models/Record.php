<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Record extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'business_hours', 'type',
    ];

    /**
     * This method create a relationship between record and historics
     */
    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function getType()
    {
        switch ($this->type) {
            case 'I':
                return 'Entry';
                break;
            case 'II':
                return 'Break Work';
                break;
            case 'OI':
                return 'Return to Work';
                break;
            case 'O':
                return 'Leave work';
                break;
        }
    }

    public function getAllTypes()
    {
        return [
            'I' => 'Entry',
            'II' => 'Break Work',
            'OI' => 'Return to Work',
            'O' => 'Leave work',
        ];
    }

    public function getDate()
    {
        return Carbon::parse($this->business_hours)->format('d/m/Y');
    }

    public function getHour()
    {
        return Carbon::parse($this->business_hours)->format('H:i:s');
    }

    public function search_personal_records(Array $data, $total_page, $id)
    {

        $records = $this->where(function ($query) use ($id, $data) {
            if (isset($data['id']))
                $query->where('id', $data['id']);
            if (isset($data['type']))
                $query->where('type', $data['type']);
            if (isset($data['date']))
                $query->whereDate('business_hours', $data['date']);
        })->where('user_id', $id);

        return $records->paginate($total_page);
    }

}
