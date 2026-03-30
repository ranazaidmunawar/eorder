<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'user_id',
        'image',
        'name',
        'rank',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'feature',
       ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
