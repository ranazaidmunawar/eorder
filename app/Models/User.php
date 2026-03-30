<?php

namespace App\Models;

use App\Models\User\Job;
use App\Models\User\SEO;
use App\Models\User\Table;
use App\Models\User\Member;
use App\Models\User\Slider;
use App\Models\User\Social;
use App\Models\User\Gallery;
use App\Models\User\Product;
use App\Models\User\Sitemap;
use App\Models\User\Customer;
use App\Models\User\Jcategory;
use App\Models\User\OrderItem;
use App\Models\User\OrderTime;
use App\Models\User\Pcategory;
use App\Models\User\TableBook;
use App\Models\User\TimeFrame;
use App\Models\User\BasicExtra;
use App\Models\User\IntroPoint;
use App\Models\User\PostalCode;
use App\Models\User\PageHeading;
use App\Models\User\BasicSetting;
use App\Models\User\MailTemplate;
use App\Models\User\ProductOrder;
use App\Models\User\PsubCategory;
use App\Models\User\BasicExtended;
use App\Models\User\ProductReview;
use App\Models\User\ServingMethod;
use App\Models\User\ShippingCharge;
use App\Models\User\UserPermission;
use App\Models\User\PosPaymentMethod;
use App\Models\User\ReservationInput;
use App\Models\User\UserCustomDomain;
use App\Models\User\ProductInformation;
use Illuminate\Notifications\Notifiable;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\ReservationInputOption;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'admin_id',
        'first_name',
        'last_name',
        'email',
        'image',
        'username',
        'password',
        'phone',
        'city',
        'state',
        'address',
        'country',
        'status',
        'featured',
        'verification_link',
        'email_verified',
        'online_status',
        'preview_template',
        'pwa',
        'pass_token',
        'restaurant_name',
        'theme_name',
        'home_show_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'user_id');
    }

    public function introPoint(): HasMany
    {
        return $this->hasMany(IntroPoint::class, 'user_id');
    }

     public function product_informations(): HasMany
    {
        return $this->hasMany(ProductInformation::class, 'user_id');
    }
    public function blog_categories(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'user_id');
    }
    public function custom_domains(): HasMany
    {
        return $this->hasMany(UserCustomDomain::class,'user_id');
    }
    public function coupons():HasMany
    {
        return $this->hasMany(\App\Models\User\Coupon::class, 'user_id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User\Role::class,'role_id');
    }
    public function faqs(): HasMany
    {
        return $this->hasMany(\App\Models\User\Faq::class, 'user_id');
    }
    public function social_media(): HasMany
    {
        return $this->hasMany(Social::class, 'user_id');
    }
    public function languages()
    {
        return $this->hasMany(\App\Models\User\Language::class, 'user_id');
    }
    public function features(): HasMany
    {
        return $this->hasMany(\App\Models\User\Feature::class, 'user_id');
    }
    public function mail_templates(): HasMany
    {
        return $this->hasMany(MailTemplate::class,'user_id');
    }


    public function menus(): HasMany
    {
        return $this->hasMany(\App\Models\User\Menu::class, 'user_id');
    }
    public function offline_gateways(): HasMany
    {
        return $this->hasMany(\App\Models\User\OfflineGateway::class, 'user_id');
    }
    public function customPageInfo(): HasMany
    {
        return $this->hasMany(PageContent::class,'user_id');
    }
    public function page_heading(): HasOne
    {
        return $this->hasOne(PageHeading::class, 'user_id');
    }
    public function payment_gateways(): HasMany
    {
        return $this->hasMany(\App\Models\User\PaymentGateway::class, 'user_id');
    }
    public function permissions(): HasMany
    {
        return $this->hasMany(UserPermission::class, 'user_id');
    }
    public function announcementPopup(): HasMany
    {
        return $this->hasMany(\App\Models\User\Popup::class,'user_id');
    }
    public function roles(): HasMany
    {
        return $this->hasMany(\App\Models\User\Role::class,'user_id');
    }
    public function social_links(): HasMany
    {
        return $this->hasMany(Social::class,'user_id');
    }
    public function subscribers(): HasMany
    {
        return $this->hasMany(\App\Models\User\Subscriber::class,'user_id');
    }
    public function testimonials(): HasMany
    {
        return $this->hasMany(\App\Models\User\Testimonial::class, 'user_id');
    }
    public function useful_links(): HasMany
    {
        return $this->hasMany(\App\Models\User\Ulink::class, 'user_id');
    }

    public function product_categories(): HasMany
    {
        return $this->hasMany(Pcategory::class,'user_id');
    }
    public function  products(): HasMany
    {
        return $this->hasMany(Product::class,'user_id');
    }
    public function postal_codes(): HasMany
    {
        return $this->hasMany(PostalCode::class,'user_id');
    }
    public function pos_payment_methods(): HasMany
    {
        return $this->hasMany(PosPaymentMethod::class,'user_id');
    }
    public function product_orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class,'user_id');
    }
    public function product_reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class,'user_id');
    }
    public function product_subcategories(): HasMany
    {
        return $this->hasMany(PsubCategory::class,'user_id');
    }
    public function reservation_inputs(): HasMany
    {
        return $this->hasMany(ReservationInput::class,'user_id');
    }
    public function reservation_input_options(): HasMany
    {
        return $this->hasMany(ReservationInputOption::class,'user_id');
    }
    public function serving_methods(): HasMany
    {
        return $this->hasMany(ServingMethod::class,'user_id');
    }
    public function shipping_charges(): HasMany
    {
        return $this->hasMany(ShippingCharge::class,'user_id');
    }
    public function sitemaps(): HasMany
    {
        return $this->hasMany(Sitemap::class,'user_id');
    }
    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class,'user_id');
    }
    public function job_categories(): HasMany
    {
        return $this->hasMany(Jcategory::class,'user_id');
    }
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class,'user_id');
    }
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class,'user_id');
    }
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class,'user_id');
    }
    public function members(): HasMany
    {
        return $this->hasMany(Member::class,'user_id');
    }
    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class,'user_id');
    }
    public function order_times(): HasMany
    {
        return $this->hasMany(OrderTime::class,'user_id');
    }
    public function tables(): HasMany
    {
        return $this->hasMany(Table::class,'user_id');
    }
    public function table_books(): HasMany
    {
        return $this->hasMany(TableBook::class,'user_id');
    }
    public function time_frames(): HasMany
    {
        return $this->hasMany(TimeFrame::class,'user_id');
    }
    public function basic_settings(): HasMany
    {
        return $this->hasMany(BasicSetting::class, 'user_id');
    }
    public function basic_extendeds(): HasMany
    {
        return $this->hasMany(BasicExtended::class, 'user_id');
    }
    public function basic_extra(): HasOne
    {
        return $this->hasOne(BasicExtra::class, 'user_id');
    }
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'user_id');
    }
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'user_id');
    }
    public function seos(): HasMany
    {
        return $this->hasMany(SEO::class, 'user_id');
    }
}
