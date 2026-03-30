<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bottomlink extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'language_id',
        'user_id',
        'url'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
