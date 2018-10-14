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

    /**
     * This method return the type in string format
     * @return string
     */
    public function getType()
    {
        switch ($this->type) {
            case 'I':
                return 'Entrada';
                break;
            case 'II':
                return 'Saída para o intervalo';
                break;
            case 'OI':
                return 'Retorno do intervalo';
                break;
            case 'O':
                return 'Saída';
                break;
        }
    }

    /**
     * This method return all types in array format
     * @return array
     */
    public function getAllTypes()
    {
        return [
            'I' => 'Entrada',
            'II' => 'Saída para o intervalo',
            'OI' => 'Retorno do intervalo',
            'O' => 'Saída',
        ];
    }

    /**
     * This method return date in respective format = d/m/Y
     * @return string
     */
    public function getDate()
    {
        return Carbon::parse($this->business_hours)->format('d/m/Y');
    }

    /**
     * This method return hour in respective format = H:m:s
     * @return string
     */
    public function getHour()
    {
        return Carbon::parse($this->business_hours)->format('H:i:s');
    }

    /**
     * This method search a personal records set based in user id, id, type and date, and return
     * set records with pagination
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function search_personal_records(Array $data, $id)
    {
        $records = $this->where(function ($query) use ($id, $data) {
            if (isset($data['id']))
                $query->where('id', $data['id']);
            if (isset($data['type']))
                $query->where('type', $data['type']);
            if (isset($data['date']))
                $query->whereDate('business_hours', $data['date']);
        })->where('user_id', $id);

        return $records;
    }

    /**
     * This method search and return record by id
     * @param $id
     * @return mixed
     */
    public function get_record_by_id($id)
    {
        return $this->where('id', $id);
    }

    /**
     * This method search and return record by id and user id
     * @param $id
     * @return mixed
     */
    public function get_record_by_id_and_user_id($id, $user_id)
    {
        return $this->where('id', $id)->where('user_id', $user_id);
    }

    /**
     * This method create a relationship between record and historics
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

}
