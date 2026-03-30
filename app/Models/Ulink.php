<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulink extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'language_id',
        'url'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
