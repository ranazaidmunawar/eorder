<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $fillable = [
        'title',
        'text',
        'language_id',
        'user_id',
        'charge',
        'free_delivery_amount'
    ];
}
