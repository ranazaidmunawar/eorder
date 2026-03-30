<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model
{
    protected $table = "product_informations";

    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'user_id',
        'product_id',
        'category_id',
        'subcategory_id',
        'summary',
        'description',
        'meta_keywords',
        'meta_description',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
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

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
