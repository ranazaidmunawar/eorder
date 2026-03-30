<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReservationInput extends Model
{
    protected $fillable = [
        'language_id',
        'user_id',
        'type',
        'label',
        'name',
        'placeholder',
        'required',
        'active',
        'order_number'
    ];

    public function reservation_input_options(): HasMany
    {
        return $this->hasMany(ReservationInputOption::class);
    }

    public function language(): BelongsTo
    {
      return $this->belongsTo(Language::class, 'language_id');
    }
}
