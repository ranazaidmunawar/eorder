<?php

namespace App\Models\User;

use App\Models\User\CustomPage\PageContent;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\Journal\BlogInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Language extends Model
{
    public $table = 'user_languages';

    protected $fillable = [
        'id',
        'name',
        'is_default',
        'code',
        'rtl',
        'user_id',
        'keywords',
        'datepicker_name'
    ];

    public function custom_page_info(): HasMany
    {
        return $this->hasMany(PageContent::class, 'language_id');
    }

    public function blogCategory(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'language_id');
    }

    public function blogInformation(): HasMany
    {
        return $this->hasMany(BlogInformation::class, 'language_id');
    }

    public function productInformation(): HasMany
    {
        return $this->hasMany(ProductInformation::class, 'language_id');
    }

    public function pcategories(): HasMany
    {
        return $this->hasMany(Pcategory::class, 'language_id');
    }

    public function psubcategories(): HasMany
    {
        return $this->hasMany(PsubCategory::class, 'language_id');
    }

    public function postal_codes(): HasMany
    {
        return $this->hasMany(PostalCode::class, 'language_id');
    }

    public function shipping_charges(): HasMany
    {
        return $this->hasMany(ShippingCharge::class, 'language_id');
    }

    public function reservation_inputs(): HasMany
    {
        return $this->hasMany(ReservationInput::class, 'language_id');
    }

    public function popups(): HasMany
    {
        return $this->hasMany(Popup::class, 'language_id');
    }

    public function job_categories(): HasMany
    {
        return $this->hasMany(Jcategory::class, 'language_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'language_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'language_id');
    }

    public function useful_links(): HasMany
    {
        return $this->hasMany(Ulink::class, 'language_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class,'language_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class,'language_id');
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class,'language_id');
    }

    public function seo(): HasOne
    {
        return $this->hasOne(SEO::class, 'language_id');
    }
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'language_id');
    }

    public function basic_setting(): HasOne
    {
        return $this->hasOne(BasicSetting::class, 'language_id');
    }

    public function basic_extended(): HasOne
    {
        return $this->hasOne(BasicExtended::class, 'language_id');
    }
}
