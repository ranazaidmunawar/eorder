<?php

namespace App\Models\User\Journal;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlogCategory extends Model
{
  use HasFactory;

  protected $table = 'user_blog_categories';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['language_id','user_id', 'name', 'status', 'serial_number', 'slug'];

  public function categoryLang()
  {
    return $this->belongsTo(Language::class,'language_id');
  }

  public function blogInfo()
  {
    return $this->hasMany(BlogInformation::class);
  }
}
