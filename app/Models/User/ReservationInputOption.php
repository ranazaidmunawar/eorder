<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationInputOption extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'label',
        'name',
        'placeholder',
        'required'
    ];

    public function reservation_input(): BelongsTo
    {
        return $this->belongsTo(ReservationInput::class);
    }
}
