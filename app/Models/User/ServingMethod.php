<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ServingMethod extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
        'gateways',
        'serial_number',
        'note',
        'website_menu',
        'qr_menu',
        'qr_payment',
        'pos',
        'user_id'
    ];
}
