<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntroPoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_intro_points';
    protected $fillable = [
        "language_id",
        'user_id',
        'image',
        'background_color',
        'title',
        'serial_number',
    ];



    public function language()
    {
        return $this->belongsTo('App\Models\User\Language');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
