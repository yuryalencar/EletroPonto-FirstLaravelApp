<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function historics(){
        return $this->hasMany(Historic::class);
    }

}
