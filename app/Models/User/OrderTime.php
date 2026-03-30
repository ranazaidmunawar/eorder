<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class OrderTime extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'day',
        'start_time',
        'end_time'
    ];
}
