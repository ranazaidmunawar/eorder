<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'image',
        'title',
        'serial_number',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
