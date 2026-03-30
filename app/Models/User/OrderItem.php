<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        "product_order_id",
        "product_id",
        "user_id",
        "customer_id",
        "title",
        "sku",
        "variations",
        "addons",
        "variations_price",
        "addons_price",
        "product_price",
        "total",
        "image",
       ];

       public function product(): BelongsTo
       {
           return $this->belongsTo(Product::class, 'product_id');
       }
        public function productInfromation(): BelongsTo
        {
            return $this->belongsTo(ProductInformation::class, 'product_id','product_id');
        }

}
