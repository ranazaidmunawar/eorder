@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use App\Models\User\ProductReview;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Home'] ?? __('Home') }}
@endsection

@section('meta-keywords', !empty($userSeo) ? $userSeo->home_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->home_meta_description : '')

@section('content')

    @includeIf('user-front.hero.slider')

    <div class="fress-area" style="@if ($userBs->feature_section == 0) padding-bottom: 0; @endif">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if ($userBs->home_version == 'slider')
                        @if (!empty($userBe->slider_bottom_img))
                            <div class="fress-thumb text-center mb-90">
                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->slider_bottom_img, $userBs) }}"
                                    alt="fress">
                            </div>
                        @else
                            <div class="fress-thumb text-center mb-90">
                                <img src="{{ asset('assets/restaurant/images/bottomimg.png') }}" alt="fress">
                            </div>
                        @endif
                    @else
                        @if (!empty($userBe->hero_bottom_img))
                            <div class="fress-thumb text-center mb-90">
                                <img src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bottom_img, $userBs) }}"
                                    alt="fress">
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            @if ($userBs->feature_section == 1)
                <div class="row fress-active {{ !empty($bottomImg) ? '' : 'pt-120' }}">
                    @foreach ($features as $feature)
                        <div class="col-lg-3">
                            <div class="single-fress white-bg text-center">
                                @if (!empty($feature->image))
                                    <img class="lazy wow fadeIn"
                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $userBs) }}"
                                        data-wow-delay="1s" data-wow-duration="1s" alt="feature">
                                @endif
                                <a href="javascript:;">{{ convertUtf8($feature->title) }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="fress-shape">
            @if ($userBs->home_version == 'slider')
                @if (!empty($userBe->slider_shape_img))
                    <img class="lazy"
                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->slider_shape_img, $userBs) }}"
                        alt="shape">
                @else
                    <img class="lazy" data-src="{{ asset('assets/restaurant/images/shape.png') }}" alt="shape">
                @endif
            @else
                @if (!empty($userBe->hero_shape_img))
                    <img class="lazy"
                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_shape_img, $userBs) }}"
                        alt="shape">
                @endif
            @endif
        </div>
    </div>

    @if ($userBs->intro_section == 1)
        <section class="experience-area">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-end">
                    <div class="col-lg-6 col-md-8">
                        <div class="experience-content">
                            @if ($userBs->intro_section_title)
                                <div class="flag"><span>{{ convertUtf8($userBs->intro_section_title) }}</span></div>
                            @endif
                            <h3 class="title wow fadeIn" data-wow-duration="2000ms" data-wow-delay="0ms">
                                {{ convertUtf8($userBs->intro_title) }}</h3>
                            <p class=" wow fadeIns" data-wow-duration="2000ms" data-wow-delay="300ms">
                                {{ convertUtf8($userBs->intro_text) }}</p>

                            @if (!empty($userBs->intro_signature))
                                <img class="lazy wow fadeIn" data-wow-duration="2000ms" data-wow-delay="600ms"
                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_signature, $userBs) }}"
                                    alt="autograph">
                            @else
                            @endif
                            <i class="flaticon-burger"></i>
                        </div>
                    </div>
                </div>
                <div class="row align-items-end">
                    @if ($userBs->intro_contact_text && $userBs->intro_contact_number)
                        <div class="col-lg-4 col-md-7">
                            <div class="experience-contact mb-50 wow fadeIn animated" data-wow-duration="2000ms"
                                data-wow-delay="300ms">
                                <span>{{ convertUtf8($userBs->intro_contact_text) }}</span>
                                <p>{{ convertUtf8($userBs->intro_contact_number) }}</p>
                                <i class="flaticon-phone-call"></i>
                            </div>
                        </div>
                    @endif
                    @if ($userBs->intro_video_image && $userBs->intro_video_link)
                        <div class="col-lg-1"></div>
                        <div class="col-lg-7">

                            <div class="experience-play-item mt-70">

                                @if ($userBs->intro_video_image)
                                    <img class="lazy wow fadeIn"
                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_video_image, $userBs) }}"
                                        alt="experience">
                                @endif
                                <div class="experience-overlay">
                                    <a class="video-popup" href="{{ $userBs->intro_video_link }}"><i
                                            class="flaticon-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($userBs->intro_main_image)

                <div class="experience-bg">
                    <img class="lazy wow fadeIn"
                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_main_image, $userBs) }}"
                        alt="experience">
                </div>
            @else
            @endif

        </section>
    @endif

    @if ($userBs->menu_section == 1)
        @if ($userBe->menu_version == 1)
            <section class="food-menu-area food-menu-2-area food-menu-3-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section-title text-center">
                                <span>{{ convertUtf8($sectionHeading?->menu_title) }}
                                    <img class="lazy" data-src="{{ asset('assets/front/img/title-icon.png') }}"
                                        alt=""></span>
                                <h3 class="title">{{ convertUtf8($sectionHeading?->menu_subtitle) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-btn pb-20">
                                <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                                    @foreach ($categories as $keys => $category)
                                        @php
                                            $featureProductCount = Product::query()
                                                ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                ->where('product_informations.category_id', $category->id)
                                                ->where('products.is_feature', 1)
                                                ->where('products.user_id', $user->id)
                                                ->count();
                                        @endphp
                                        <li class="nav-item">

                                            <a class="nav-link {{ $keys == 0 ? 'active' : '' }}"
                                                id="{{ $category->slug }}-tab" data-toggle="pill"
                                                href="#{{ $category->slug }}" role="tab"
                                                aria-controls="{{ $category->slug }}" aria-selected="true">
                                                @if (!empty($category->image))
                                                    <img class="lazy wow fadeIn"
                                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $userBs) }}"
                                                        data-wow-delay=".5s" alt="menu">
                                                @endif
                                                <input type="hidden" value="{{ $category->id }}" class="id">
                                                <p @if (empty($category->image)) style="padding-top: 0;" @endif>
                                                    {{ convertUtf8($category->name) }}
                                                    ({{ $featureProductCount }})
                                                </p>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="pills-tabContent">
                                @foreach ($categories as $key => $category)
                                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                        id="{{ $category->slug }}" role="tabpanel"
                                        aria-labelledby="{{ $category->slug }}-tab">

                                        <div class="button-group filters-button-group">
                                            <button class="button is-checked" data-filter="*"
                                                @if ($category->subcategories()->where('is_feature', 1)->where('user_id', $user->id)->count() == 0) style="display:none;" @endif>{{ $keywords['All'] ?? __('All') }}</button>
                                            @foreach ($category->subcategories()->where('is_feature', 1)->where('user_id', $user->id)->where('language_id', $userCurrentLang->id)->get() as $subcat)
                                                <button class="button"
                                                    data-filter=".sub{{ $subcat->id }}">{{ $subcat->name }}</button>
                                            @endforeach
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="food-items-loader">
                                                <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
                                            </div>
                                            @php
                                                $featureActiveProducts = Product::query()
                                                    ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                    ->where('product_informations.category_id', $category->id)
                                                    ->where('products.is_feature', 1)
                                                    ->where('products.user_id', $user->id)
                                                    ->where('products.status', 1)
                                                    ->get();
                                            @endphp
                                            @if (count($featureActiveProducts) > 0)
                                                @foreach ($featureActiveProducts as $product)
                                                    <div class="col-lg-6">
                                                        <div class="food-menu-items">
                                                            <div
                                                                class="single-menu-item mt-30 sub{{ $product->subcategory_id }}">
                                                                <div class="item-details">
                                                                    <div class="menu-thumb">
                                                                        <img class="lazy wow fadeIn"
                                                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                                            alt="menu" data-wow-delay=".5s">
                                                                        <div class="thumb-overlay">
                                                                            <a
                                                                                href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"><i
                                                                                    class="flaticon-add"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="menu-content ml-30">

                                                                        <a class="title"
                                                                            href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">{{ convertUtf8($product->title) }}
                                                                        </a>
                                                                        @if (in_array('Online Order', $packagePermissions))
                                                                            <div class="rate mt-1">
                                                                                <div class="rating"
                                                                                    style="width:{{ !empty($product->product_reviews)? ProductReview::where('user_id', $user->id)->where('product_id', $product->product_id)->avg('review') * 20: 0 }}%">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <p>
                                                                            {{ convertUtf8(strlen($product->summary)) > 70 ? convertUtf8(substr($product->summary, 0, 70)) . '...' : convertUtf8($product->summary) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="menu-price-btn">
                                                                    @if (in_array('Online Order', $packagePermissions))
                                                                        <a class="cart-link d-md-none d-block btn mobile"
                                                                            data-product="{{ $product }}"
                                                                            data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">+</a>
                                                                        <a class="cart-link d-none d-md-block"
                                                                            data-product="{{ $product }}"
                                                                            data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}
                                                                        </a>
                                                                        <span>{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                        </span>
                                                                        @if (convertUtf8($product->previous_price))
                                                                            <del>
                                                                                {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                        @endif
                                                                    @else
                                                                        @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                                                            <a class="main-btn cart-link show"
                                                                                data-product="{{ $product }}"
                                                                                data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ?? __('Extras') }}
                                                                            </a>
                                                                            <span
                                                                                class="hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                            </span>
                                                                            @if (convertUtf8($product->previous_price))
                                                                                <del>
                                                                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                            @endif
                                                                        @else
                                                                            <a class="main-btn hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                            </a>
                                                                            <span
                                                                                class="show">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                            </span>
                                                                            @if (convertUtf8($product->previous_price))
                                                                                <del>
                                                                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                @if ($product->is_special == 1)
                                                                    <div class="flag flag-2">
                                                                        <span>{{ __('Special') }}</span>
                                                                    </div>
                                                                @endif

                                                            </div>


                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-lg-12">
                                                    <div class="menu-more-btn text-center mt-40">
                                                        <a
                                                            href="{{ route('user.front.items', getParam()) }}">{{ $keywords['View All Items'] ?? __('View All Items') }}</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-12 bg-light py-5 mt-4">
                                                    <h4 class="text-center">
                                                        {{ $keywords['Product Not Found'] ?? __('Product Not Found') }}
                                                    </h4>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            @if (!empty($userBe->menu_section_img))
                <style>
                    .food-menu-area .food-menu-items.menu-2::before {
                        background-image: url("{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->menu_section_img, $userBs) }}");
                    }
                </style>
            @endif
            <section class="food-menu-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section-title text-center">
                                <span>{{ convertUtf8($userBe->menu_section_title) }}
                                    <img src="{{ asset('assets/front/img/title-icon.png') }}" alt="">
                                </span>
                                <h3 class="title">{{ convertUtf8($userBe->menu_section_subtitle) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-btn pb-20">
                                <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                                    @foreach ($categories as $keys => $category)
                                        @php
                                            $featureProductCount = Product::query()
                                                ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                ->where('product_informations.category_id', $category->id)
                                                ->where('products.is_feature', 1)
                                                ->where('products.user_id', $user->id)
                                                ->count();
                                        @endphp
                                        <li class="nav-item">
                                            <a class="nav-link {{ $keys == 0 ? 'active' : '' }}"
                                                id="{{ convertUtf8($category->slug) }}-tab" data-toggle="pill"
                                                href="#{{ convertUtf8($category->slug) }}" role="tab"
                                                aria-controls="{{ convertUtf8($category->slug) }}" aria-selected="true">
                                                @if (!empty($category->image))
                                                    <img class="lazy wow fadeIn"
                                                        src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $userBs) }}"
                                                        data-wow-delay=".5s" alt="menu">
                                                @endif
                                                <p @if (empty($category->image)) style="padding-top: 0;" @endif>
                                                    {{ convertUtf8($category->name) }}
                                                    ({{ $featureProductCount }})
                                                </p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content" id="pills-tabContent">
                                @foreach ($categories as $key => $category)
                                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                        id="{{ convertUtf8($category->slug) }}" role="tabpanel"
                                        aria-labelledby="{{ convertUtf8($category->slug) }}-tab">

                                        <div class="button-group filters-button-group">
                                            <button class="button is-checked" data-filter="*"
                                                @if ($category->subcategories()->where('is_feature', 1)->where('user_id', $user->id)->count() == 0) style="display:none;" @endif>
                                                {{ __('All') }}
                                            </button>
                                            @foreach ($category->subcategories()->where('is_feature', 1)->where('user_id', $user->id)->get() as $subcat)
                                                <button class="button"
                                                    data-filter=".sub{{ $subcat->id }}">{{ $subcat->name }}</button>
                                            @endforeach
                                        </div>

                                        <div class="food-menu-items menu-2">


                                            <div class="food-items-loader">
                                                <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
                                            </div>

                                            @php
                                                $featureActiveProducts = Product::query()
                                                    ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                    ->where('product_informations.category_id', $category->id)
                                                    ->where('products.is_feature', 1)
                                                    ->where('products.user_id', $user->id)
                                                    ->where('products.status', 1)
                                                    ->get();
                                            @endphp
                                            @if (count($featureActiveProducts) > 0)
                                                @foreach ($featureActiveProducts as $product)
                                                    <div class="single-menu-item mt-30 sub{{ $product->subcategory_id }}">
                                                        <div class="menu-thumb">
                                                            <img class="lazy wow fadeIn"
                                                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                                data-wow-delay=".5s" alt="menu">
                                                            <div class="thumb-overlay">
                                                                <a
                                                                    href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                                    <i class="flaticon-add"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menu-content ml-30">
                                                            <a class="title"
                                                                href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">{{ convertUtf8($product->title) }}</a>
                                                            <p>
                                                                {{ convertUtf8(strlen($product->summary)) > 180 ? convertUtf8(substr($product->summary, 0, 180)) . '...' : convertUtf8($product->summary) }}
                                                            </p>
                                                        </div>
                                                        <div class="menu-price-btn menu-2">
                                                            @if (in_array('Online Order', $packagePermissions))
                                                                <a class="cart-link d-md-none d-block btn mobile"
                                                                    data-product="{{ $product }}"
                                                                    data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">+</a>
                                                                <a class="cart-link d-none d-md-block"
                                                                    data-product="{{ $product }}"
                                                                    data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}
                                                                </a>
                                                                <span>{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                </span>
                                                                @if (convertUtf8($product->previous_price))
                                                                    <del>
                                                                        {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                @endif
                                                            @else
                                                                @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                                                    <a class="main-btn cart-link show"
                                                                        data-product="{{ $product }}"
                                                                        data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ?? __('Extras') }}
                                                                    </a>
                                                                    <span
                                                                        class="hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                    </span>
                                                                    @if (convertUtf8($product->previous_price))
                                                                        <del>
                                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                    @endif
                                                                @else
                                                                    <a class="main-btn hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                    </a>
                                                                    <span
                                                                        class="show">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                                                    </span>
                                                                    @if (convertUtf8($product->previous_price))
                                                                        <del>
                                                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                        @if ($product->is_special == 1)
                                                            <div class="flag flag-2"><span>{{ __('Special') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-lg-12 bg-light py-5 mt-4">
                                                    <h4 class="text-center">
                                                        {{ $keywords['Product Not Found'] ?? __('Product Not Found') }}
                                                    </h4>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="menu-more-btn text-center mt-75">
                                                    <a
                                                        href="{{ route('user.front.items', [getParam(), 'category_id' => $category->id]) }}">{{ __('View All Items') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </section>
        @endif
    @endif

    @if ($userBs->special_section == 1)
        <section class="good-food-area pt-180 pb-120 gray-bg">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-8">
                        <div class="special-items">
                            @if ($special_product->count() > 0)
                                @foreach ($special_product as $sproduct)
                                    <div class="good-food-item white-bg text-center">
                                        <div class="food-shape">
                                            <img class="food-shape-img"
                                                src="{{ asset('assets/tenant/img/special_shape.png') }}">
                                        </div>

                                        <h3 class="title">
                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($sproduct->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                        </h3>
                                        @if (!empty(convertUtf8($sproduct->previous_price)))
                                            <del
                                                class="preprice">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($sproduct->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                        @endif
                                        <div class="rate mx-auto mt-3">
                                            <div class="rating"
                                                style="width:{{ !empty($product->product_reviews)? ProductReview::where('user_id', $user->id)->where('product_id', $product->product_id)->avg('review') * 20: 0 }}%">
                                            </div>
                                        </div>
                                        <a class="title"
                                            href="{{ route('user.front.product.details', [getParam(), $sproduct->slug, $sproduct->product_id]) }}">{{ convertUtf8($sproduct->title) }}</a>
                                        <p>
                                            {{ convertUtf8(strlen($sproduct->summary)) > 70 ? convertUtf8(substr($sproduct->summary, 0, 70)) . '...' : convertUtf8($sproduct->summary) }}
                                        </p>
                                        <img class="lazy wow fadeIn"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $sproduct->feature_image, $userBs) }}"
                                            alt="">
                                        <div class="special-btns">
                                            <a class="cart-link" data-product="{{ $sproduct }}"
                                                data-href="{{ route('user.front.add.cart', [getParam(), $sproduct->product_id]) }}">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h3>{{ $keywords['NO SPECIAL PRODUCT FOUND!'] ?? __('NO SPECIAL PRODUCT FOUND!') }}</h3>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="menu-list-content text-right d-none d-lg-block">
                            @php
                                $parts = preg_split('/\s+/', convertUtf8($userBe->special_section_title));
                            @endphp
                            <ul>
                                @foreach ($parts as $part)
                                    <li>{{ convertUtf8($part) }}</li>
                                @endforeach
                            </ul>
                            <a
                                href="{{ route('user.front.product', getParam()) }}"><span>{{ convertUtf8($userBe->special_section_subtitle) }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($userBs->team_section == 1)
        <section class="team-area" style="{{ $members->count() == 0 ? 'background:#f1f1f1' : '' }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="section-title text-center">
                            <span>{{ convertUtf8($sectionHeading?->team_title) }} <img
                                    src="{{ asset('assets/front/img/title-icon.png') }}" alt=""></span>
                            <h3 class="title">{{ convertUtf8($sectionHeading?->team_subtitle) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @if ($members->count() > 0)
                        @foreach ($members as $member)
                            <div class="col-lg-4 col-md-7 col-sm-9">
                                <div class="single-team mt-30">
                                    <div class="team-thumb">
                                        @if ($member->image)
                                            <img class="lazy wow fadeIn"
                                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_MEMBER_IMAGES, $member->image, $userBs) }}"
                                                data-wow-delay=".5s" data-wow-duration="1s" alt="team">
                                        @endif
                                        <div class="team-overlay">
                                            <div class="link">
                                                <a><i class="flaticon-add"></i></a>
                                            </div>
                                            <div class="social">
                                                <ul>
                                                    @if ($member->facebook)
                                                        <li><a href="{{ $member->facebook }}"><i
                                                                    class="flaticon-facebook"></i></a></li>
                                                    @endif
                                                    @if ($member->twitter)
                                                        <li><a href="{{ $member->twitter }}"><i
                                                                    class="flaticon-twitter"></i></a></li>
                                                    @endif
                                                    @if ($member->instagram)
                                                        <li><a href="{{ $member->instagram }}"><i
                                                                    class="flaticon-instagram"></i></a></li>
                                                    @endif
                                                    @if ($member->linkedin)
                                                        <li><a href="{{ $member->linkedin }}"><i
                                                                    class="flaticon-linkedin"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="team-content text-center">
                                        <h4 class="title">{{ convertUtf8($member->name) }}</h4>
                                        <span>{{ convertUtf8($member->rank) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>{{ $keywords['NO MEMBERS FOUND!'] ?? __('NO MEMBERS FOUND!') }}</h3>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if ($userBs->testimonial_section == 1)
        <section class="client-area bg_cover pt-105 pb-95 lazy"
            data-bg="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->testimonial_bg_img, $userBs) }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="client-title text-center">
                            <h3 class="title">{{ convertUtf8($sectionHeading?->testimonial_title) }}</h3>

                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        @if ($testimonials->count() > 0)
                            <div class="client-items client-active">

                                @foreach ($testimonials as $testimonial)
                                    <div class="single-client">
                                        <div class="text">
                                            <p>{{ convertUtf8($testimonial?->comment) }}</p>
                                        </div>
                                        <div class="client-info d-block d-sm-flex justify-content-between">
                                            <div class="item-1">
                                                @if ($testimonial->image)
                                                    <img class="lazy wow fadeIn"
                                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                        alt="clients">
                                                @endif
                                                <span>{{ convertUtf8($testimonial->name) }}</span>
                                                <p>{{ convertUtf8($testimonial->rank) }}</p>
                                            </div>
                                            <div class="item-2 text-sm-right text-left">
                                                <ul>
                                                    @php
                                                        $i = 0;
                                                        for ($i == 1; $i < $testimonial->rating; $i++) {
                                                            echo '<li><i class="flaticon-star"></i></li>';
                                                        }
                                                    @endphp
                                                </ul>
                                                <span>({{ $testimonial->rating }} {{ __('Stars') }})</span>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <h3 class="text-center">{{ $keywords['NO CLIEND FOUND!'] ?? __('NO CLIEND FOUND!') }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($userBs->news_section == 1)
        <section class="blog-area pb-95 pt-105" style="{{ $blogs->count() == 0 ? 'background:#f1f1f1' : '' }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="section-title text-center">
                            <span>{{ convertUtf8($sectionHeading?->blog_title) }} <img
                                    src="{{ asset('assets/front/img/title-icon.png') }}" alt=""></span>
                            <h3 class="title">{{ convertUtf8($sectionHeading?->blog_subtitle) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @if ($blogs->count() > 0)
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4">
                                <div class="single-blog mt-30">
                                    <div class="blog-thumb">
                                        <img class="lazy wow fadeIn"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs) }}"
                                            alt="" data-wow-delay=".5s" data-wow-duration="1s">
                                    </div>
                                    <div class="blog-content">
                                        <a
                                            href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}">
                                            <h3 class="title">
                                                {{ strlen(convertUtf8($blog->title)) > 27 ? mb_substr(convertUtf8($blog->title), 0, 27, 'UTF-8') . '...' : convertUtf8($blog->title) }}
                                            </h3>
                                        </a>
                                        <p>
                                            {{ convertUtf8(strlen(strip_tags($blog->content)) > 100) ? convertUtf8(substr(strip_tags($blog->content), 0, 100)) . '...' : convertUtf8(strip_tags($blog->content)) }}
                                        </p>

                                        <div
                                            class="blog-comments d-block d-sm-flex justify-content-between align-items-center">
                                            <a
                                                href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}">{{ $keywords['Read_More'] ?? __('Read More') }}</a>
                                            <ul>
                                                @php
                                                    app()->setLocale($userCurrentLang->code);
                                                @endphp
                                                <li><i class="far fa-calendar-alt"></i>
                                                    {{ Carbon::parse($blog->created_at)->diffForHumans() }}
                                                    <span>|</span> {{ $keywords['Admin'] ?? __('Admin') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="section-title text-center">
                                    <h3>{{ $keywords['NO BLOG POST FOUND!'] ?? __('NO BLOG POST FOUND!') }}</h3>
                                </div>
                            </div>
                        </div>


                </div>
    @endif
    </div>

    </section>
    @endif

    @if ($userBs->is_quote == 1)
        @if ($userBs->table_section == 1)
            <section class="reservation-area bg_cover pt-4">
                <div id="map">

                    <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $userBs->latitude }},%20{{ $userBs->longitude }}+(My%20Business%20Name)&amp;t=&amp;z={{ $userBs->map_zoom }}&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                </div>
            </section>
        @endif
    @endif



@endsection
