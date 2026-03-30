<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{

    protected $fillable = [
        'user_id',
        'language_id',
        'text',
        'text_font_size',
        'title',
        'title_font_size',
        'button_text',
        'button_text_font_size',
        'button_url',
        'button_text1',
        'button_text1_font_size',
        'button_url1',
        'image',
        'bg_image',
        'title_color',
        'text_color',
        'button_color',
        'serial_number',

    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
