<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = [
        'language_id',
        'user_id',
        'image',
        'serial_number',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
