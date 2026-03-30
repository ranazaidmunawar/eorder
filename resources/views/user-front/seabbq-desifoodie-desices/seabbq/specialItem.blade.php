   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;
   @endphp
   <section class="featured-section pt-lg-120 pt-60 pb-70">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="text-center">
                       <h2 class="title mb-24" data-aos="fade-up" data-aos-delay="150">
                           {!! @$userBe->special_section_title ?? 'Our Special Seafood Items' !!}
                       </h2>
                   </div>
               </div>
           </div>
           <!-- featured slider -->
           <div data-aos="fade-up" data-aos-delay="200">
               <div class="featured-slider-area">
                   <div class="swiper default-slider pb-70" id="default-slider-featured" data-slidespace="24"
                       data-xsmview="1" data-smview="2" data-mdview="3" data-lgview="3" data-xlview="4">
                       <div class="swiper-wrapper">
                           @forelse ($special_product as $sproduct)
                               <div class="swiper-slide">
                                   <div class="product-card">
                                       <div class="card-image">
                                           <a
                                               href="{{ route('user.front.product.details', [getParam(), $sproduct->slug, $sproduct->product_id]) }}">
                                               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                   data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $sproduct->feature_image, $userBs) }}"
                                                   alt="featured">
                                           </a>
                                           <x-add-to-cart :product="$sproduct" :keywords="$keywords" :activeTheme="$activeTheme" />
                                       </div>
                                       <div class="content">
                                           <h6 class="body-font fw-semibold lc-1">
                                               <a
                                                   href="{{ route('user.front.product.details', [getParam(), $sproduct->slug, $sproduct->product_id]) }}">{{ convertUtf8($sproduct->title) }}</a>
                                           </h6>
                                           <div class="price">
                                               <span
                                                   class="new-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($sproduct->current_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                               @if (!empty(convertUtf8($sproduct->previous_price)))
                                                   <span
                                                       class="old-price">{{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ convertUtf8($sproduct->previous_price) }}{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                               @endif
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                       <div class="swiper-pagination" id="default-slider-featured-pagination"></div>
                   </div>
               </div>
           </div>
       </div>
       <div class="shape-area">
           <div class="shape-1" data-aos="fade-right" data-aos-delay="500">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ !empty($userBe->special_left_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->special_left_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                   alt="shape">
           </div>
           <div class="shape-2" data-aos="fade-left" data-aos-delay="500">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ !empty($userBe->special_right_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->special_right_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                   alt="shape">
           </div>
       </div>
   </section>
