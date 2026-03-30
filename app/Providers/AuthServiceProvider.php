<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\User;
use App\Models\User\Coupon;
use App\Models\User\CustomPage\Page;
use App\Models\User\Feature;
use App\Models\User\Gallery;
use App\Models\User\Job;
use App\Models\User\Journal\Blog;
use App\Models\User\Journal\BlogCategory;
use App\Models\User\MailTemplate;
use App\Models\User\Member;
use App\Models\User\Pcategory;
use App\Models\User\Product;
use App\Models\User\ProductOrder;
use App\Models\User\PsubCategory;
use App\Models\User\ReservationInput;
use App\Models\User\Role;
use App\Models\User\ShippingCharge;
use App\Models\User\Slider;
use App\Models\User\Social;
use App\Models\User\Testimonial;
use App\Policies\BlogPolicy;
use App\Policies\BlogCategoryPolicy;
use App\Policies\CouponPolicy;
use App\Policies\FeaturePolicy;
use App\Policies\FrontProductOrderPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\JobPolicy;
use App\Policies\MailTemplatePolicy;
use App\Policies\MemberPolicy;
use App\Policies\PagePolicy;
use App\Policies\PcategoryPolicy;
use App\Policies\ProductOrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PsubCategoryPolicy;
use App\Policies\ReservationInputPolicy;
use App\Policies\RolePolicy;
use App\Policies\ShippingChargePolicy;
use App\Policies\SliderPolicy;
use App\Policies\SocialPolicy;
use App\Policies\TestimonialPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
        BlogCategory::class => BlogCategoryPolicy::class,
        ProductOrder::class => ProductOrderPolicy::class,
        ShippingCharge::class => ShippingChargePolicy::class,
        Coupon::class => CouponPolicy::class,
        Pcategory::class => PcategoryPolicy::class,
        PsubCategory::class => PsubCategoryPolicy::class,
        Product::class => ProductPolicy::class,
        ReservationInput::class => ReservationInputPolicy::class,
        Page::class => PagePolicy::class,
        Slider::class => SliderPolicy::class,
        Feature::class => FeaturePolicy::class,
        Testimonial::class => TestimonialPolicy::class,
        Member::class => MemberPolicy::class,
        Gallery::class => GalleryPolicy::class,
        Job::class => JobPolicy::class,
        MailTemplate::class => MailTemplatePolicy::class,
        Social::class => SocialPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
