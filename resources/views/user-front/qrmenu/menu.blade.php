@php
  use App\Constants\Constant;
  use App\Http\Helpers\Uploader;
  use App\Models\User\Product;
  use App\Models\User\ProductReview;
@endphp

@extends('user-front.qrmenu.layout')

@section('page-heading')
  {{ $keywords['QR Menu'] ?? __('QR Menu') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->product_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->product_meta_description : '')

@section('content')

  <section class="food-menu-area food-menu-2-area food-menu-3-area">
    <div class="container">
      <div class="categories-tab">
        <div class="row">
          <div class="col-lg-12">
            <div class="tabs-btn pb-20">
              <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                @foreach ($categories as $keys => $category)
                  <li class="nav-item ml-1 mr-1">
                    <a class="nav-link {{ $keys == 0 ? 'active' : '' }}" id="{{ $category->slug }}-tab" data-toggle="pill"
                      href="#{{ $category->slug }}" role="tab" aria-controls="{{ $category->slug }}"
                      aria-selected="true">
                      <p>{{ convertUtf8($category->name) }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="tab-content" id="pills-tabContent">
            @foreach ($categories as $key => $category)
              <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="{{ $category->slug }}" role="tabpanel"
                aria-labelledby="{{ $category->slug }}-tab">
                <div class="button-group filters-button-group d-flex justify-content-center">
                  <button class="button is-checked base-bg" data-filter="*"
                    @if ($category->subcategories()->where('language_id', $cLang->id)->where('user_id', $user->id)->count() == 0) style="display: none;" @endif>{{ $keywords['All'] ?? __('All') }}</button>
                  @foreach ($category->subcategories()->where('language_id', $cLang->id)->where('user_id', $user->id)->get() as $subcat)
                    @if ($subcat->status == 1)
                      <button class="button ml-1 mr-1" data-filter=".sub{{ $subcat->id }}">
                        {{ $subcat->name }}
                      </button>
                    @endif
                  @endforeach
                </div>
                @php
                  $activeProducts = Product::query()
                      ->join('product_informations', 'products.id', 'product_informations.product_id')
                      ->where('product_informations.category_id', $category->id)
                      ->where('products.user_id', $user->id)
                      ->where('products.status', 1)
                      ->get();
                @endphp
                <div class="row justify-content-center">
                  @if (count($activeProducts) > 0)
                    @foreach ($activeProducts as $product)
                      <div class="col-lg-6">
                        <div class="food-menu-items">
                          <div class="single-menu-item mt-30 sub{{ $product->subcategory_id }}">
                            <div class="item-details">
                              <div class="menu-thumb">
                                <img class="lazy"
                                  data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                  alt="menu">
                                <div class="thumb-overlay">
                                  <a href="#"><i class="flaticon-add"></i></a>
                                </div>
                              </div>
                              <div class="menu-content ml-3">
                                <a class="title" href="#">
                                  {{ $product->title }}
                                </a>
                                @if (in_array('Online Order', $packagePermissions))
                                  <div class="rate mt-1">
                                    <div class="rating"
                                      style="width:{{ $product->rating > 0? ProductReview::where('user_id', $user->id)->where('product_id', $product->product_id)->avg('review') * 20: 0 }}%">
                                    </div>
                                  </div>
                                @endif
                                <p> {{ $product->summary }} </p>
                              </div>
                            </div>
                            <div class="menu-price-btn">
                              @if (in_array('Online Order', $packagePermissions))
                                <a class="cart-link" data-product="{{ $product }}"
                                  data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add_to_Cart'] ??  'Add to Cart' }}
                                </a>
                                <span>{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                </span>
                                @if ($product->previous_price)
                                  <del>
                                    {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                  </del>
                                @endif
                              @else
                                @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                  <a class="cart-link show" data-product="{{ $product }}"
                                    data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ?? __('Extras') }}
                                  </a>
                                  <span
                                    class="hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                  </span>
                                  @if ($product->previous_price)
                                    <del>
                                      {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                    </del>
                                  @endif
                                @else
                                  <a class="main-btn hide">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}
                                    {{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                  </a>
                                  <span
                                    class="show">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                  </span>
                                  @if ($product->previous_price)
                                    <del>
                                      {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}
                                    </del>
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

  @includeIf('user-front.qrmenu.partials.qr-variation-modal')

@endsection
