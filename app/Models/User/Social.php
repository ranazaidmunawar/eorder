<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public $timestamps = false;

    protected $table = "user_social_links";

    protected $fillable = [
        'user_id',
        'icon',
        'url',
        'serial_number'
    ];
}
