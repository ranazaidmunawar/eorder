<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHeading extends Model
{
  use HasFactory;

    public $table = 'user_page_headings';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'language_id',
    'user_id',
    'blog_page_title',
    'blog_details_page_title',
    'menu_page_title',
    'menu_details_page_title',
    'contact_page_title',
    'gallery_page_title',
    'faq_page_title',
    'career_page_title',
    'career_details_page_title',
    'team_member_page_title',
    'reservation_page_title',
    'food_item_page_title',
    'food_item_details_page_title',
    'login_page_title',
    'signup_page_title'
  ];

  public function headingLang()
  {
    return $this->belongsTo(Language::class,'language_id');
  }
}
