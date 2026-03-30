<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $table = 'user_sitemaps';

    protected $fillable = [
        'sitemap_url',
        'filename',
        'user_id'
    ];

}
