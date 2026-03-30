<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Language extends Model
{
    protected $fillable = [
        'id',
        'name',
        'is_default',
        'code',
        'rtl'
    ];

    public function basic_setting(): HasOne
    {
        return $this->hasOne(BasicSetting::class,'language_id');
    }

    public function basic_extended(): HasOne
    {
        return $this->hasOne(BasicExtended::class, 'language_id');
    }

    public function menus(): HasOne
    {
        return $this->hasOne(Menu::class,'language_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class,'language_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class,'language_id');
    }

    public function ulinks(): HasMany
    {
        return $this->hasMany(Ulink::class,'language_id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class,'language_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class,'language_id');
    }

    public function bcategories(): HasMany
    {
        return $this->hasMany(Bcategory::class,'language_id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class,'language_id');
    }

    public function popups(): HasMany
    {
        return $this->hasMany(Popup::class,'language_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class,'language_id');
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class,'language_id');
    }

    public function seo(): HasOne
    {
        return $this->hasOne(Seo::class,'language_id');
    }
}
