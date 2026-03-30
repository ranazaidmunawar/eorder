<?php

namespace App\Models;

use App\Models\User\OrderItem;
use App\Models\User\ProductOrder;
use App\Models\User\ProductReview;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'email',
        'photo',
        'username',
        'password',
        'number',
        'city',
        'state',
        'address',
        'country',
        'billing_fname',
        'billing_lname',
        'billing_email',
        'billing_photo',
        'billing_number',
        'billing_city',
        'billing_state',
        'billing_address',
        'billing_country',
        'shipping_fname',
        'shipping_lname',
        'shipping_email',
        'shipping_number',
        'shipping_city',
        'shipping_state',
        'shipping_address',
        'shipping_country',
        'status',
        'verification_link',
        'email_verified',
        'billing_country_code',
        'shipping_country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_items(): HasMany
    {
      return $this->hasMany(OrderItem::class);
    }

    public function product_reviews(): HasMany
    {
      return $this->hasMany(ProductReview::class);
    }

    
}
