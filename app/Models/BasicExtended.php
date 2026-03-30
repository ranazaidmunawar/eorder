<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicExtended extends Model
{
    protected $table = 'basic_extendeds';

    public $timestamps = false;

    protected $fillable = [
        'testimonial_img'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
