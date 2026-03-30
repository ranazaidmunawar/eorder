@php
 use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use App\Models\User\ProductReview;

@endphp
   <!-- Product-area start -->
   <section class="product-area product-2 pt-100 pb-75">
       <div class="container">
           <div class="row">
               <div class="col-12">
                   <div class="section-title title-center mb-30" data-aos="fade-up">
                       <h2 class="title mb-30">{{ convertUtf8($userBe->menu_section_title) }}</h2>
                       <div class="tabs-navigation tabs-navigation-2">
                           <ul class="nav nav-tabs border-bottom" data-hover="fancyHover">

                               @foreach ($categories as $keys => $category)
                                   <li class="nav-item {{ $keys == 0 ? 'active' : '' }}">
                                       <button class="nav-link hover-effect {{ $keys == 0 ? 'active' : '' }} btn-lg"
                                           data-bs-toggle="tab" data-bs-target="#{{ $category->slug }}"
                                           type="button">{{ convertUtf8($category->name) }}
                                       </button>
                                   </li>
                               @endforeach

                           </ul>
                       </div>
                   </div>
               </div>
               <div class="col-12">
                   <div class="tab-content" data-aos="fade-up">
                       @foreach ($categories as $keys => $category)
                           <div class="tab-pane slide {{ $keys == 0 ? 'show active' : '' }}" id="{{ $category->slug }}">
                               <div class="tabs-navigation text-center mb-50">
                                   <ul class="nav nav-tabs" data-hover="fancyHover">
                                       @foreach ($category->subcategories()->where('is_feature', 1)->get() as $subkeys => $subcat)
                                           <li class="nav-item {{ $subkeys == 0 ? 'active' : '' }}">
                                               <button
                                                   class="nav-link hover-effect {{ $subkeys == 0 ? 'active' : '' }} btn-md rounded-pill"
                                                   data-bs-toggle="tab" data-bs-target="#sub_{{ $subcat->id }}"
                                                   type="button">{{ convertUtf8($subcat->name) }}
                                               </button>
                                           </li>
                                       @endforeach

                                   </ul>
                               </div>
                               <div class="tab-content">
                                   @foreach ($category->subcategories()->where('is_feature', 1)->get() as $subkeys => $subcat)
                                       <div class="tab-pane slide {{ $subkeys == 0 ? 'show active' : '' }}"
                                           id="sub_{{ $subcat->id }}">
                                           <div class="row">
                                               @php
                                                   $featureActiveProducts = Product::query()
                                                       ->join('product_informations', 'product_informations.product_id', 'products.id')
                                                       ->where('product_informations.category_id', $category->id)
                                                       ->where('product_informations.subcategory_id', $subcat->id)
                                                       ->where('products.is_feature', 1)
                                                       ->where('products.user_id', $user->id)
                                                       ->where('products.status', 1)
                                                       ->get();
                                               @endphp

                                               @foreach ($featureActiveProducts as $product)
                                                   <div class="col-md-6 col-lg-4 col-xl-3 item">
                                                       <div class="product radius-md text-center p-30 mb-25">
                                                           <figure class="product-img mb-20 mx-auto">
                                                               <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                   target="_self"
                                                                   title="{{ convertUtf8($product->title) }}"
                                                                   class="lazy-container ratio ratio-1-1 bg-none">
                                                                   <img class="lazyload"
                                                                       data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $product->feature_image, $userBs) }}"
                                                                       alt="Image">
                                                               </a>
                                                               <div class="hover-show">
                                                                @if (in_array('Online Order', $packagePermissions))
                                                                   <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       class="cart-link btn btn-md btn-outline rounded-pill"
                                                                       title="{{ $keywords['Add to Cart'] ??  __('Add to Cart') }}" target="_self"
                                                                       data-product="{{ $product }}"
                                                                       data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Add to Cart'] ??  __('Add to Cart')  }}</a>
                                                                       @else
                                                                       @if (!empty(json_decode($product->addons, true)) || !empty(json_decode($product->variations, true)))
                                                                        <a href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       class="cart-link btn btn-md btn-outline rounded-pill"
                                                                       title="{{ $keywords['Extras'] ??  __('Extras') }}" target="_self"
                                                                       data-product="{{ $product }}"
                                                                       data-href="{{ route('user.front.add.cart', [getParam(), $product->product_id]) }}">{{ $keywords['Extras'] ??  __('Extras')  }}</a>
                                                                       @endif
                                                                       @endif
                                                               </div>
                                                           </figure>
                                                           <div class="product-details">
                                                               <h4 class="product-title lc-1 mb-1"><a
                                                                       href="{{ route('user.front.product.details', [getParam(), $product->slug, $product->product_id]) }}"
                                                                       target="_self"
                                                                       title="{{ convertUtf8($product->title) }}">{{ convertUtf8($product->title) }}</a>
                                                               </h4>
                                                               <div class="ratings justify-content-center mb-10">
                                                                   <div class="rate">
                                                                       <div class="rating-icon"
                                                                           style="width:{{ $product->rating ? $product->rating * 20 : 0 }}% !important">
                                                                       </div>
                                                                   </div>
                                                                   <span
                                                                       class="ratings-total">({{ $product->rating }})</span>
                                                               </div>
                                                               <div class="product-price">
                                                                   <span class="h6 font-lg new-price color-primary"
                                                                       dir="ltr">{{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->current_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                                                                   @if ($product->previous_price)
                                                                       <span class="prev-price font-sm" dir="ltr">
                                                                           {{ $userBe->base_currency_symbol_position == 'left' ? $userBe->base_currency_symbol : '' }}{{ convertUtf8($product->previous_price) }}{{ $userBe->base_currency_symbol_position == 'right' ? $userBe->base_currency_symbol : '' }}</span>
                                                                   @endif
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               @endforeach

                                           </div>
                                       </div>
                                   @endforeach
                               </div>
                               <div class="cta-btn text-center mt-15 mb-25">
                                   <a href="{{ route('user.front.items', [getParam(), 'category_id' => $category->id]) }}"
                                       class="btn btn-lg btn-primary rounded-pill" title="{{ $keywords['View All Items'] ??  __('View All Items') }}"
                                       target="_self">{{ $keywords['View All Items'] ??  __('View All Items') }}</a>
                               </div>
                           </div>
                       @endforeach
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- Product-area end -->
