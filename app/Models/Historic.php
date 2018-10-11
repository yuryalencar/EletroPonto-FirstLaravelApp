<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Historic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'record_id', 'business_hours',
    ];

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
     * This method create a relationship between record and historics
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

}
