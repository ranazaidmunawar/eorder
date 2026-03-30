<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulink extends Model
{
    public $timestamps = false;

    public $table = 'user_ulinks';

    protected $fillable = [
        'id',
        'name',
        'language_id',
        'user_id',
        'url'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
