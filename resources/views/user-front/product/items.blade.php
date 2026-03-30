@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use App\Models\User\ProductReview;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Items'] ?? __('Items') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->product_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->product_meta_description : '')
@section('content')

    @include('user-front.breadcrum', ['title' => $upageHeading?->items_page_title])

    <div class="shop-bar-area pt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop-search mt-30">
                        <input type="text" placeholder="{{ $keywords['Search_Keywords'] ?? __('Search Keywords') }}"
                            class="input-search" name="search" value="{{ request()->input('search') }}">
                        <i class="fas fa-search input-search-btn cursor-pointer"></i>
                    </div>
                </div>

                <div class="col-lg-7"></div>

                <div class="col-lg-2">
                    <div class="shop-dropdown mt-30 float-right">
                        <select name="type" id="type_sort" class="form-control">
                            <option value="new" {{ request()->input('type') == 'new' ? 'selected' : '' }}>
                                {{ $keywords['Newest_Product'] ?? __('Newest Product') }}</option>
                            <option value="old" {{ request()->input('type') == 'old' ? 'selected' : '' }}>
                                {{ $keywords['Oldest_Product'] ?? __('Oldest Product') }}</option>
                            <option value="high-to-low" {{ request()->input('type') == 'high-to-low' ? 'selected' : '' }}>
                                {{ $keywords['Price:_High_To_Low'] ?? __('Price: High To Low') }}</option>
                            <option value="low-to-high" {{ request()->input('type') == 'low-to-high' ? 'selected' : '' }}>
                                {{ $keywords['Price:_Low_To_High'] ?? __('Price: Low To High') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="pricing-area pt-20 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop-sidebar">
                        <div class="shop-box shop-category">
                            <div class="sidebar-title">
                                <h4 class="title">{{ $keywords['Category'] ?? __('Category') }}</h4>
                            </div>

                            <div class="category-item">
                                <ul>
                                    <li class="{{ request()->input('category_id') == '' ? 'active-search' : '' }}"><a
                                            href="{{ route('user.front.items', getParam()) }}"
                                            class="cursor-pointer">{{ $keywords['ALL'] ?? __('All') }}</a>
                                    </li>
                                    @foreach ($categories as $category)
                                        @php
                                            if (request()->filled('subcategory_id')) {
                                                $f_s_category = $category
                                                    ->subcategory()
                                                    ->where('id', request()->input('subcategory_id'))->where('language_id',$userCurrentLang->id)
                                                    ->select('category_id')
                                                    ->first();
                                                if ($f_s_category) {
                                                    $selected_category_id = $f_s_category->category_id;
                                                } else {
                                                    $selected_category_id = null;
                                                }
                                            } else {
                                                $selected_category_id = null;
                                            }

                                        @endphp
                                        <li data-toggle="collapse" data-target="#collapse{{ $category->id }}"
                                            class="{{ request()->input('category_id') == $category->id ? 'active-search' : '' }}"
                                            {{ request()->input('category_id') == $category->id ? "aria-expanded='true'" : '' }}
                                            {{ request()->input('subcategory_id') == $selected_category_id ? "aria-expanded='true'" : '' }}>
                                            <a href="{{ route('user.front.items', [getParam(), 'category_id' => $category->id]) }}"
                                                class="cursor-pointer">{{ convertUtf8($category->name) }}</a>

                                        </li>

                                        @if ($category->subcategories && request()->input('category_id') && request()->input('category_id') == $category->id)
                                            <ul class="subitem">
                                                @foreach ($category->subcategories()->where('language_id',$userCurrentLang->id)->get() as $sub)
                                                    @if ($sub->status == 1)
                                                        <li
                                                            class="{{ request()->input('subcategory_id') == $sub->id ? 'active-search' : '' }}">
                                                            <div id="collapse{{ $sub->category_id }}"
                                                                class="collapse {{ request()->input('subcategory_id') == $sub->id ? 'show' : '' }} {{ request()->input('category_id') == $sub->category_id ? 'show' : '' }}">
                                                                <a href="{{ route('user.front.items', [getParam(), 'category_id' => $category->id, 'subcategory_id' => $sub->id]) }}"
                                                                    class="cursor-pointer">
                                                                    {{ $sub->name }}
                                                                </a>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>

                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                         @if (in_array('Online Order', $packagePermissions))
                        <div class="shop-box shop-filter mt-30">
                            <div class="sidebar-title">
                                <h4 class="title">{{ $keywords['Filter_Products'] ?? __('Filter Products') }}</h4>
                            </div>
                            <div class="filter-item">
                                <ul class="checkbox_common checkbox_style2">
                                    <li>
                                        <input type="radio" class="review_val" name="review_value"
                                            {{ request()->input('review') == '' ? 'checked' : '' }} id="checkbox4"
                                            value="">
                                        <label for="checkbox4"><span></span>
                                            {{ $keywords['Show_All'] ?? __('Show All') }}</label>
                                    </li>

                                    <li>

                                        <input type="radio" class="review_val" name="review_value" id="checkbox5"
                                            value="4" {{ request()->input('review') == 4 ? 'checked' : '' }}
                                            id="checkbox4" value="all">
                                        <label for="checkbox5"><span></span>4
                                            {{ $keywords['Star_and_higher'] ?? __('Star and higher') }}</label>
                                    </li>

                                    <li>
                                        <input type="radio" class="review_val" name="review_value" id="checkbox6"
                                            value="3" {{ request()->input('review') == 3 ? 'checked' : '' }}
                                            id="checkbox4" value="all">
                                        <label for="checkbox6"><span></span>3
                                            {{ $keywords['Star_and_higher'] ?? __('Star and higher') }}</label>
                                    </li>

                                    <li>
                                        <input type="radio" class="review_val" name="review_value" id="checkbox7"
                                            value="2" {{ request()->input('review') == 2 ? 'checked' : '' }}
                                            id="checkbox4" value="all">
                                        <label for="checkbox7"><span></span>2
                                            {{ $keywords['Star_and_higher'] ?? __('Star and higher') }}</label>
                                    </li>

                                    <li>
                                        <input type="radio" class="review_val" name="review_value" id="checkbox8"
                                            value="1" {{ request()->input('review') == 1 ? 'checked' : '' }}
                                            id="checkbox4" value="all">
                                        <label for="checkbox8"><span></span>1
                                            {{ $keywords['Star_and_higher'] ?? __('Star and higher') }}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="shop-box shop-price mt-30">
                            <div class="sidebar-title">
                                <h4 class="title">{{ $keywords['Star_and_higher'] ?? __('Filter By Price') }}</h4>
                            </div>
                            <div class="price-item">
                                <div class="price-range-box ">
                                    <form action="#">
                                        <div id="slider-range"></div>
                                        <span>{{ $keywords['Price'] ?? __('Price') . ':' }} </span>
                                        <input type="text" name="text" id="amount">
                                        <button class="btn filter-button"
                                            type="button">{{ $keywords['Filter'] ?? __('Filter') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row justify-content-start">
                        @if ($products->count() > 0)
                        @foreach ($products as $product)

                                <div class="col-lg-4 col-md-7 col-sm-8">
                                    <div class="single-pricing text-center mt-30">
                                        @if ($product->is_special == 1)
                                            <div class="flag">
                                                <span>{{ $keywords['Special'] ?? __('Special') }}</span>
                                            </div>
                                        @endif
                                        <a class="pricing-thumb"
                                            href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                            <img class="lazy wow fadeIn"
                                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                alt="" data-wow-delay=".5s">
                                        </a>
                                        <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"><span>{{ strlen($product->title) > 27 ? mb_substr($product->title, 0, 27, 'UTF-8') . '...' : $product->title }}</span></a>

                                        <p class="lc-2">
                                            {{ $product->summary }}
                                        </p>

                                        @if (in_array('Online Order', $packagePermissions))
                                        <div class="rate mx-auto">
                                            <div class="rating"
                                                style="width:{{ !empty($product->product_reviews)? ProductReview::where('user_id', $user->id)->where('product_id', $product->product_id)->avg('review') * 20: 0 }}%">
                                            </div>
                                        </div>
                                        @endif

                                        <h3 class="title">
                                            {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                            @if (convertUtf8($product->previous_price))
                                                <small>
                                                    <del>{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                                        {{ convertUtf8($product->previous_price) }}
                                                        {{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</del>
                                                </small>
                                            @endif
                                        </h3>

                                        @if (in_array('Online Order', $packagePermissions))
                                            <a class="main-btn cart-link" data-product="{{ $product }}"
                                                data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}
                                            </a>
                                        @else
                                            @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                                <a class="main-btn cart-link" data-product="{{ $product }}"
                                                    data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ?? __('Extras') }}
                                                </a>
                                            @else
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="bg-light py-5 mt-4">
                                    <h4 class="text-center">
                                        {{ $keywords['Product Not Found'] ?? __('Product Not Found') }}</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $products->appends(['minprice' => request()->input('minprice'), 'maxprice' => request()->input('maxprice'), 'category_id' => request()->input('category_id'), 'type' => request()->input('type'), 'tag' => request()->input('tag'), 'review' => request()->input('review')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $maxprice = Product::query()
            ->where('user_id', $user->id)
            ->max('current_price');
        $minprice = 0;
    @endphp
    <form id="searchForm" class="d-none" action="{{ route('user.front.items', getParam()) }}" method="get">
        <input type="hidden" id="search" name="search"
            value="{{ !empty(request()->input('search')) ? request()->input('search') : '' }}">
        <input type="hidden" id="minprice" name="minprice"
            value="{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}">
        <input type="hidden" id="maxprice" name="maxprice"
            value="{{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}">
        <input type="hidden" name="category_id" id="category_id"
            value="{{ !empty(request()->input('category_id')) ? request()->input('category_id') : null }}">

        <input type="hidden" name="subcategory_id" id="subcategory_id"
            value="{{ !empty(request()->input('subcategory_id')) ? request()->input('subcategory_id') : null }}">

        <input type="hidden" name="type" id="type"
            value="{{ !empty(request()->input('type')) ? request()->input('type') : 'new' }}">

        <input type="hidden" name="review" id="review"
            value="{{ !empty(request()->input('review')) ? request()->input('review') : '' }}">
        <button id="search-button" type="submit"></button>
    </form>



@endsection


@section('script')
    <script>
        "use strict";
        const sliderMinPrice = '{{ !empty(request()->input('minprice')) ? request()->input('minprice') : $minprice }}';
        const sliderMaxPrice = '{{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}';
        const sliderInitMax = '{{ $maxprice }}';
    </script>
    <script src="{{ asset('assets/front/js/items.js') }}"></script>
@endsection
