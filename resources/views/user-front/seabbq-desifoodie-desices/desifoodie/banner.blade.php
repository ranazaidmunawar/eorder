   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;
   @endphp
   <!-- ======= START banner section ========= -->
   <section class="product-section pt-lg-70 pt-50">
       <div class="container">
           <div class="row gx-xl-5">
               <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                   <div class="banner-md-vertical mb-30 bg-cover bg-img"
                       data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, @$left_banner->image, $userBs) }}">
                       <div class="card-text">
                           <span class="subtitle mb-10">{{ @$left_banner->title }}</span>
                           <h3 class="title lc-2 mb-10"><a
                                   href="{{ @$left_banner->button_url }}">{{ @$left_banner->subtitle }}</a></h3>
                           <p class="desc mb-24">
                               {!! @$left_banner->text !!}
                           </p>
                           @if (isset($left_banner->button_url))
                               <a href="{{ @$left_banner->button_url }}"
                                   class="btn thm-btn">{{ @$left_banner->button_text }}</a>
                           @endif
                       </div>
                   </div>
               </div>

               <div class="col-lg-6">
                   <div class="row">
                       <div class="col-lg-12">
                           <div class="section-title-inline mb-40" data-aos="fade-up" data-aos-delay="100">
                               <h2 class="title mb-0">
                                   {{ @$bannerSection->title }}
                               </h2>
                               <a href="#" class="btn thm-btn">{{ $keywords['Show_All'] ?? 'Show All' }}</a>
                           </div>
                       </div>
                       <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                           @if (count($banner_products) == 0)
                               <h3 class="text-center">{{ $keywords['NO PRODUCT FOUND!'] ?? 'NO PRODUCT FOUND!' }}</h3>
                           @else
                               <div class="product2-slider-area">
                                   <div class="swiper default-slider pb-10" id="default-slider-product2"
                                       data-slidespace="24" data-xsmview="1" data-smview="2" data-mdview="2"
                                       data-lgview="2" data-xlview="2">
                                       <div class="swiper-wrapper">
                                           @foreach ($banner_products as $banner_product)
                                               <div class="swiper-slide">
                                                   <div class="product-card mb-30">
                                                       <div class="card-image">
                                                           <a
                                                               href="{{ route('user.front.product.details', [getParam(), $banner_product->slug, $banner_product->product_id]) }}">
                                                               <img class="blur-up lazyload"
                                                                   src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                                   data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $banner_product->feature_image, $userBs) }}"
                                                                   alt="product">
                                                           </a>
                                                                   <x-add-to-cart :product="$banner_product" :keywords="$keywords" :activeTheme="$activeTheme" />
                                                       </div>
                                                       <div class="content">
                                                           <h6 class="body-font fw-semibold lc-1">
                                                               <a
                                                                   href="{{ route('user.front.product.details', [getParam(), $banner_product->slug, $banner_product->product_id]) }}">
                                                                   {{ convertUtf8($banner_product->title) }}
                                                               </a>
                                                           </h6>
                                                           <div class="price">
                                                               <span
                                                                   class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($banner_product->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                               @if (!empty(convertUtf8($banner_product->previous_price)))
                                                                   <span
                                                                       class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($banner_product->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                               @endif
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           @endforeach
                                       </div>
                                       <div class="swiper-pagination" id="default-slider-product2-pagination">
                                       </div>
                                   </div>
                               </div>
                           @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- ======= End banner section ========= -->
