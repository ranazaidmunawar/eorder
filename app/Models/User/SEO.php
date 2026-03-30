<?php


namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    use HasFactory;

    protected $table = 'user_seos';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'language_id',
        'home_meta_keywords',
        'home_meta_description',
        'career_meta_keywords',
        'career_meta_description',
        'blogs_meta_keywords',
        'blogs_meta_description',
        'gallery_meta_keywords',
        'gallery_meta_description',
        'faqs_meta_keywords',
        'faqs_meta_description',
        'contact_meta_keywords',
        'contact_meta_description',
        'reservation_meta_keywords',
        'reservation_meta_description',
        'team_meta_keywords',
        'team_meta_description',
        'product_meta_keywords',
        'product_meta_description',
        'checkout_meta_keywords',
        'checkout_meta_description',
        'login_meta_keywords',
        'login_meta_description',
        'sign_up_meta_keywords',
        'sign_up_meta_description',
        'forget_password_meta_keywords',
        'forget_password_meta_description',
        'cart_meta_keywords',
        'cart_meta_description'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
