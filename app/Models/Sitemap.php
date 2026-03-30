<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $table = 'sitemaps';

    protected $fillable = [
        'sitemap_url',
        'filename',
    ];

}
