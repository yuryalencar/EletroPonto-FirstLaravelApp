<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
