<?php

namespace App\Models\User;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'user_id',
        'review',
        'comment'
    ];

    public function client()
    {
        return $this->hasOne(Client::class,'id','customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
