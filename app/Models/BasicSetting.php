<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'intro_subtitle',
        'intro_title',
        'intro_text',
        'intro_main_image',
        'team_section_title',
        'team_section_subtitle',
        'home_section',
        'template_section',
        'process_section',
        'featured_users_section',
        'pricing_section',
        'partners_section',
        'intro_section',
        'intro_section_button_text',
        'intro_section_button_url',
        'intro_section_video_url',
        'testimonial_section',
        'news_section',
        'top_footer_section',
        'copyright_section',
        'footer_text',
        'copyright_text',
        'footer_logo',
        'maintainance_mode',
        'maintainance_text',
        'maintenance_img',
        'maintenance_status',
        'secret_path',
        'aws_access_key_id',
        'aws_secret_access_key',
        'aws_default_region',
        'aws_bucket',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
