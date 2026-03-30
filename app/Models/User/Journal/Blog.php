<?php

namespace App\Models\User\Journal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
  use HasFactory;

  public $table ="user_blogs";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'image', 'serial_number'];

  public function information()
  {
    return $this->hasMany(BlogInformation::class);
  }
}
