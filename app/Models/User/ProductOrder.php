<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class ProductOrder extends Model
{
    use Notifiable;

    protected $fillable = [
        'customer_id',
        'user_id',
        'membership_id',
        "billing_country",
        "billing_fname",
        "billing_lname",
        "billing_address",
        "billing_city",
        "billing_email",
        "billing_number",
        "shipping_country",
        "shipping_fname",
        "shipping_lname",
        "shipping_address",
        "shipping_city",
        "shipping_email",
        "shipping_number",
        "shipping_charge",
        "total",
        "method",
        "currency_code",
        "currency_code_position",
        "currency_symbol",
        "currency_symbol_position",
        "order_number",
        "shipping_charge",
        "payment_status",
        "txnid",
        "charge_id",
        "order_status",
        'invoice_number',
        'order_notes',
        'tax',
        'coupon',
        'delivery_date',
        'delivery_time_start',
        'delivery_time_end',
        'conversation_id'
    ];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->billing_country_code . $this->billing_number;
    }
}
