<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
  public $timestamps = true;

  protected $fillable = [
    "language_id",
    "bcategory_id",
    "title",
    "slug",
    "main_image",
    "content",
    "meta_keywords",
    "meta_description",
    "serial_number",
  ];

  public function bcategory(): BelongsTo
  {
    return $this->belongsTo(Bcategory::class);
  }

  public function language(): BelongsTo
  {
    return $this->belongsTo(Language::class);
  }
  public function category()
  {
    return $this->belongsTo(Bcategory::class, 'bcategory_id');
  }
}
