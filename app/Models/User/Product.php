<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'feature_image',
        'variations',
        'keywords',
        'addons',
        'current_price',
        'previous_price',
        'rating',
        'status',
        'is_feature',
        'addon_keywords',
        'product_id',
        'indx'
    ];
    public function information()
    {
        return $this->hasMany(ProductInformation::class);
    }
    public function category()
    {
        return $this->hasOne(Pcategory::class, 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(PsubCategory::class, 'id', 'subcategory_id');
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function product_images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','product_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
