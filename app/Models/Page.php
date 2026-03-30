<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
