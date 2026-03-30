     @php
         use App\Constants\Constant;
         use App\Http\Helpers\Uploader;
         use Illuminate\Support\Facades\Auth;
     @endphp
     <!-- ======= START pricing section ========= -->
     <section class="pricing-section">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="text-center">
                         <h2 class="title mb-lg-40 mb-30" data-aos="fade-up" data-aos-delay="100">
                             {{ @$affordable_deals->section_title ?? 'We Offer Flexible Price' }}
                         </h2>
                     </div>
                 </div>
             </div>
             <div class="row justify-content-center">
                 @if (count($affordable_products) > 0)
                     @foreach ($affordable_products as $index => $affordable_product)
                         <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                             <div class="pricing-card mb-30">
                                 <div class="card-bg">
                                     <img src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/priceing-card-bg-3.png') }}" alt="img">
                                 </div>
                                 <div class="content">
                                     <h3>
                                         <a
                                             href="{{ route('user.front.product.details', [getParam(), $affordable_product->slug, $affordable_product->product_id]) }}">
                                             {{ convertUtf8($affordable_product->title) }}
                                         </a>
                                     </h3>
                                     <div class="price mb-24">
                                         <span class="new-price">
                                             {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}
                                             {{ convertUtf8($affordable_product->current_price) }}
                                             {{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                                         </span>

                                         @if (!empty($affordable_product->previous_price))
                                             <span class="old-price">
                                                 {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}
                                                 {{ convertUtf8($affordable_product->previous_price) }}
                                                 {{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                                             </span>
                                         @endif
                                     </div>
                                     <div class="mb-0">
                                         {!! \Illuminate\Support\Str::limit(strip_tags($affordable_product->summary), 100) !!}
                                     </div>
                                 </div>

                                 <div class="product-image mb-10 bg-img"
                                     data-bg-image="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/priceing-card-bg-4.png') }}">
                                     <a
                                         href="{{ route('user.front.product.details', [getParam(), $affordable_product->slug, $affordable_product->product_id]) }}">
                                         <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                             data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_FEATURED_IMAGE, $affordable_product->feature_image, $userBs) }}"
                                             alt="product">
                                     </a>
                                 </div>
                                 <x-add-to-cart :product="$affordable_product" :keywords="$keywords" :activeTheme="$activeTheme" />
                             </div>
                         </div>
                     @endforeach
                 @else
                     <h3 class="text-center">{{ $keywords['No product found'] ?? 'No product found' }}</h3>
                 @endif
             </div>
         </div>
     </section>
     <!-- ======= End pricing section ========= -->
