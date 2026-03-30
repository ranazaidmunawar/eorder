@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use App\Models\User\ProductReview;
@endphp

@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Product'] ?? __('Product') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->product_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->product_meta_description : '')

@section('content')

    @include('user-front.breadcrum', ['title' => $upageHeading?->menu_page_title])


    <section class="food-menu-area food-menu-2-area food-menu-3-area pt-90">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    @if ($categories->count() > 0)
                        {{-- tab-navigation-v4 --}}
                        <div class="tabs-btn tab-navigation-v4 mb-40">
                            <div class="sliderTab">
                                @foreach ($categories as $keys => $category)
                                    @php
                                        $productCount = Product::query()
                                            ->join(
                                                'product_informations',
                                                'product_informations.product_id',
                                                'products.id',
                                            )
                                            ->where('product_informations.category_id', $category->id)
                                            ->where('products.user_id', $user->id)
                                            ->count();
                                    @endphp

                                    <div class="single-tab">
                                        <a class="nav-link {{ $keys == 0 ? 'active' : '' }}"
                                            id="{{ convertUtf8($category->slug) }}-tab" data-toggle="pill"
                                            href="#{{ convertUtf8($category->slug) }}" role="tab"
                                            aria-controls="{{ convertUtf8($category->slug) }}" aria-selected="true">
                                            <p>{{ convertUtf8($category->name) }} ({{ $productCount }})</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <h3> {{ $keywords['No Menu Found!'] ?? __('No Menu Found!') }} </h3>
                        </div>
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="tab-content" id="pills-tabContent">
                        @foreach ($categories as $key => $category)
                            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                                id="{{ convertUtf8($category->slug) }}" role="tabpanel"
                                aria-labelledby="{{ convertUtf8($category->slug) }}-tab">

                                <div class="sliderTab-filter-wrap">
                                    <button type="button" class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                                    <button type="button" class="slider-next"><i class="fas fa-chevron-right"></i></button>

                                    <div class="button-group swiper sliderTab-filter filters-button-group">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <button class="button is-checked" data-filter="*"
                                                    @if ($category->subcategories()->where('language_id', $cLang->id)->where('user_id', $user->id)->count() == 0) style="display: none;" @endif>
                                                    {{ $keywords['ALL'] ?? __('All') }}
                                                </button>

                                            </div>
                                            @foreach ($category->subcategories()->where('language_id', $cLang->id)->where('user_id', $user->id)->get() as $subcat)
                                                @if ($subcat->status == 1)
                                                    <div class="swiper-slide">
                                                        <button class="button" data-filter=".sub{{ $subcat->id }}">
                                                            {{ $subcat->name }}
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">

                                    <div class="food-items-loader">
                                        <img src="{{ asset('assets/admin/img/loader.gif') }}" alt="">
                                    </div>

                                    @php
                                        $activeProducts = Product::query()
                                            ->join(
                                                'product_informations',
                                                'product_informations.product_id',
                                                'products.id',
                                            )
                                            ->where('status', 1)
                                            ->where('product_informations.category_id', $category->id)
                                            ->where('products.user_id', $user->id)
                                            ->get();
                                    @endphp
                                    @if (count($activeProducts) > 0)
                                        @foreach ($activeProducts as $product)
                                            <div class="col-lg-6">
                                                <div class="food-menu-items">
                                                    <div class="single-menu-item mt-30 sub{{ $product->subcategory_id }}">
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
                                                                    href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">{{ strlen($product->title) > 27 ? mb_substr($product->title, 0, 27, 'UTF-8') . '...' : $product->title }}
                                                                </a>

                                                                @if (in_array('Online Order', $packagePermissions))
                                                                    <div class="rate mt-1">
                                                                        <div class="rating"
                                                                            style="width:{{ !empty($product->product_reviews) ? ProductReview::where('user_id', $user->id)->where('product_id', $product->product_id)->avg('review') * 20 : 0 }}%">
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <p>{{ convertUtf8(strlen($product->summary)) > 60 ? substr(convertUtf8($product->summary), 0, 60) . '...' : convertUtf8($product->summary) }}
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
                                                                    data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add_to_Cart'] ?? 'Add to Cart' }}
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
                                                                <span>{{ $keywords['Special'] ?? __('Special') }}</span>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-lg-12 bg-light py-5 mt-4">
                                            <h4 class="text-center">
                                                {{ $keywords['Product Not Found'] ?? __('Product Not Found') }}</h4>
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

@endsection
