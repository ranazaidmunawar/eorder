<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class TableBook extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'email',
        'fields',
        'status',
        'membership_id'
    ];
}
