<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    public $timestamps = false;

    public $table = 'user_features';

    protected $fillable = [
        'language_id',
        'user_id',
        'image',
        'title',
        'serial_number',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
