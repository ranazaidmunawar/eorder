<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicExtra extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "user_basic_extras";

    protected $fillable = ['user_id'];
}
