<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $table = "packages";

    protected $fillable = [
        'title',
        'slug',
        'price',
        'term',
        'featured',
        'recommended',
        'icon',
        'is_trial',
        'trial_days',
        'status',
        'storage_limit',
        'staff_limit',
        'order_limit',
        'categories_limit',
        'subcategories_limit',
        'items_limit',
        'table_reservation_limit',
        'language_limit',
        'features',
        'meta_keywords',
        'meta_description',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
