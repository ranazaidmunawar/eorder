<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicExtended extends Model
{
    protected $table = 'user_basic_extendeds';

    public $timestamps = false;

    protected $fillable = [
        'base_color',
        'office_time',
        'base_currency_symbol',
        'base_currency_symbol_position',
        'base_currency_text',
        'base_currency_text_position',
        'base_currency_rate',
        'home_version',
        'user_id',
        'language_id',
        'from_mail',
        'from_name',
        'author_image',

        'hero_left_image',
        'hero_right_image',
        'hero_section_button_text1_url',
        'hero_section_button2_url',
        'hero_section_title',
        'top_header_support_text',

        'top_header_support_email',
        'top_header_middle_text',
        'featured_category_section_title',

        'featured_section_title',
        'featured_right_shape_image',
        'featured_left_shape_image',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
