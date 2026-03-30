<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "user_coupons";

    protected $fillable = [
        'user_id',
        'name',
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'packages',
        'maximum_uses_limit',
        'total_uses',
        'minimum_spend'
    ];
}
