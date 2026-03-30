<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    public $timestamps = false;

    public $table='user_testimonials';

    protected $fillable = [
        'language_id',
        'user_id',
        'image',
        'comment',
        'name',
        'rank',
        'rating',
        'serial_number',
        'background_image'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
