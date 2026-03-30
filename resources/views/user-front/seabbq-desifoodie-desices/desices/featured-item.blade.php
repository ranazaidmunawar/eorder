@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;
@endphp

<!-- ======= START product-tab section ========= -->
<section class="product-tab-section pt-lg-70 pt-50 pb-lg-90 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2 class="title mb-24" data-aos="fade-up" data-aos-delay="150">
                        {!! @$userBe->featured_section_title !!}
                    </h2>
                    <!-- tabs-navigation -->
                    <div class="tabs-navigation tabs-navigation-v2 text-center mb-20" data-aos="fade-up"
                        data-aos-delay="200">
                        <ul class="nav nav-tabs gap-24" data-hover="fancyHover">
                            <li class="nav-item active">
                                <button class="nav-link radius-sm hover-effect active" data-bs-toggle="tab"
                                    data-bs-target="#all-cat-items"
                                    type="button">{{ $keywords['All'] ?? 'All' }}</button>
                            </li>
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <button class="nav-link radius-sm hover-effect" data-bs-toggle="tab"
                                        data-bs-target="#cat-{{ $category->id }}"
                                        type="button">{{ $category->name }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab-content -->
        <div class="tab-content" id="product_TabContent" data-aos="fade-up" data-aos-delay="300">
            <!-- All Products -->
            <div class="tab-pane fade show active" id="all-cat-items" role="tabpanel" tabindex="0">
                <div class="row">
                    @foreach ($featured_products as $featured_product)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-card mb-30">
                                <div class="card-image">
                                    <a
                                        href="{{ route('user.front.product.details', [getParam(), $featured_product->slug, $featured_product->product_id]) }}">
                                        <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $featured_product->feature_image, $userBs) }}"
                                            alt="product">
                                    </a>
                                    <x-add-to-cart :product="$featured_product" :keywords="$keywords" :activeTheme="$activeTheme" />
                                </div>
                                <div class="content">
                                    <h6 class="title body-font fw-semibold lc-1">
                                        <a
                                            href="{{ route('user.front.product.details', [getParam(), $featured_product->slug, $featured_product->product_id]) }}">
                                            {{ convertUtf8($featured_product->title) }}
                                        </a>
                                    </h6>
                                    <div class="price">
                                        <span
                                            class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($featured_product->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                        @if (!empty(convertUtf8($featured_product->previous_price)))
                                            <span
                                                class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($featured_product->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category Tabs -->
            @foreach ($categories as $category)
                @php
                    $category_products = $featured_products->where('category_id', $category->id);
                    $subcategories = $category
                        ->subcategories()
                        ->where('is_feature', 1)
                        ->where('user_id', $user->id)
                        ->where('language_id', $userCurrentLang->id)
                        ->get();
                @endphp

                <div class="tab-pane fade" id="cat-{{ $category->id }}" role="tabpanel" tabindex="0">

                    <!-- If subcategories exist -->
                    @if ($subcategories->count() > 0)
                        <div class="tabs-navigation tabs-navigation-v2 text-center mb-20">
                            <ul class="nav nav-tabs gap-14 justify-content-center" data-hover="fancyHover" id="subTabs-{{ $category->id }}"
                                role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link hover-effect active" id="sub-all-{{ $category->id }}-tab"
                                        data-bs-toggle="tab" data-bs-target="#sub-all-{{ $category->id }}"
                                        type="button" role="tab">
                                        {{ $keywords['All'] ?? 'All' }}
                                    </button>
                                </li>
                                @foreach ($subcategories as $subcat)
                                    <li class="nav-item">
                                        <button class="nav-link hover-effect" id="sub-{{ $subcat->id }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#sub-{{ $subcat->id }}" type="button" role="tab">
                                            {{ $subcat->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="tab-content" id="subTabsContent-{{ $category->id }}">
                            <!-- All subcategory products -->
                            <div class="tab-pane fade show active" id="sub-all-{{ $category->id }}" role="tabpanel">
                                <div class="row">
                                    @foreach ($category_products as $product)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="product-card mb-30">
                                                <div class="card-image">
                                                    <a
                                                        href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                        <img class="blur-up lazyload"
                                                            src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                            alt="product">
                                                    </a>
                                                    <x-add-to-cart :product="$product" :keywords="$keywords"
                                                        :activeTheme="$activeTheme" />
                                                </div>
                                                <div class="content">
                                                    <h6 class="title body-font fw-semibold lc-1">
                                                        <a
                                                            href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                            {{ convertUtf8($product->title) }}
                                                        </a>
                                                    </h6>
                                                    <div class="price">
                                                        <span
                                                            class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                        @if (!empty($product->previous_price))
                                                            <span
                                                                class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Individual subcategory tabs -->
                            @foreach ($subcategories as $subcat)
                                @php
                                    $sub_products = $category_products->where('subcategory_id', $subcat->id);
                                @endphp
                                <div class="tab-pane fade" id="sub-{{ $subcat->id }}" role="tabpanel">
                                    <div class="row">
                                        @if ($sub_products->count() > 0)
                                            @foreach ($sub_products as $sub_product)
                                                <div class="col-lg-3 col-md-4 col-6">
                                                    <div class="product-card mb-30">
                                                        <div class="card-image">
                                                            <a
                                                                href="{{ route('user.front.product.details', [getParam(), $sub_product->slug, $sub_product->product_id]) }}">
                                                                <img class="blur-up lazyload"
                                                                    src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $sub_product->feature_image, $userBs) }}"
                                                                    alt="product">
                                                            </a>
                                                            <x-add-to-cart :product="$sub_product" :keywords="$keywords"
                                                                :activeTheme="$activeTheme" />
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="title body-font fw-semibold lc-1">
                                                                <a
                                                                    href="{{ route('user.front.product.details', [getParam(), $sub_product->slug, $sub_product->product_id]) }}">
                                                                    {{ convertUtf8($sub_product->title) }}
                                                                </a>
                                                            </h6>
                                                            <div class="price">
                                                                <span
                                                                    class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($sub_product->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                                @if (!empty($sub_product->previous_price))
                                                                    <span
                                                                        class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($sub_product->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h5 class="text-center mb-0">
                                                {{ $keywords['Product Not Found'] ?? 'Product Not Found' }}!
                                            </h5>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Subcategory -->
                        <div class="row">
                            @if ($category_products->count() > 0)
                                @foreach ($category_products as $product)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <div class="product-card mb-30">
                                            <div class="card-image">
                                                <a
                                                    href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                    <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                        alt="product">
                                                </a>
                                                <x-add-to-cart :product="$product" :keywords="$keywords"
                                                    :activeTheme="$activeTheme" />
                                            </div>
                                            <div class="content">
                                                <h6 class="title body-font fw-semibold lc-1">
                                                    <a
                                                        href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}">
                                                        {{ convertUtf8($product->title) }}
                                                    </a>
                                                </h6>
                                                <div class="price">
                                                    <span
                                                        class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                    @if (!empty($product->previous_price))
                                                        <span
                                                            class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-center">
                                    {{ $keywords['Product Not Found'] ?? 'Product Not Found' }}!
                                </h4>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ======= END product-tab section ========= -->
