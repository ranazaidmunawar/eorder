<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasicSetting extends Model
{
    public $table = 'user_basic_settings';

    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'user_id',
        'intro_section_title',
        'intro_title',
        'intro_text',
        'intro_contact_text',
        'intro_contact_number',
        'intro_video_image',
        'intro_signature',
        'intro_video_link',
        'intro_main_image',
        'team_section_title',
        'team_section_subtitle',
        'feature_section',
        'intro_section',
        'menu_section',
        'team_section',
        'testimonial_section',
        'news_section',
        'special_section',
        'instagram_section',
        'table_section',
        'top_footer_section',
        'copyright_section',
        'footer_text',
        'copyright_text',
        'footer_logo',
        'reservation_title',
        'storage_usage',
        'maintenance_img',
        'maintenance_text',
        'maintenance_mode',
        'ips',
        'base_color',
        'home_version',
        'postal_code',
        'aws_status',
        'support_email',
        'support_phone',
        'website_title',
        'logo',
        'favicon',
        'intro_section_video_button_text',
        'intro_section_button_text',
        'intro_section_button_url',
        'intro_section_top_shape_image',
        'intro_section_bottom_shape_image',
        'intro_section_blockquote_text',
        'intro_section_author_image',
        'breadcrumb',
        'intro_left_side_image',
        'intro_right_side_image',
        'blog_section_bg_image',
        'banner_section',
        'featured_category_section',
        'affordable_section',

    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
