<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public $timestamps = false;

    protected $table = 'user_subscribers';
}
