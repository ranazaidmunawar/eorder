<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PsubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language_id',
        'user_id',
        'category_id',
        'status',
        'slug',
        'indx'
    ];


    function category(): BelongsTo
    {
        return $this->belongsTo(Pcategory::class,  'category_id');
    }

    function products(): HasMany
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
    function product_informations(): HasMany
    {
        return $this->hasMany(ProductInformation::class, 'subcategory_id','id');
    }
}
