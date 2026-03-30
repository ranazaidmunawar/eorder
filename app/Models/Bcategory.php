<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bcategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
      "language_id",
      "name",
      "status",
      "serial_number",
     ];

    public function blogs(): HasMany
    {
      return $this->hasMany(Blog::class);
    }
    public function countBlogNumber()
    {
      return $this->hasMany(Blog::class, 'bcategory_id');
    }
}
