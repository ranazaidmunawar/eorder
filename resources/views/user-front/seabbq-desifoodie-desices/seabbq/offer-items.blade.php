         @php
             use App\Constants\Constant;
             use App\Http\Helpers\Uploader;
             use Illuminate\Support\Facades\Auth;
         @endphp
         <section class="pricing-section pt-lg-90 pt-60 pb-lg-90 pb-40">
             <div class="container">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="text-center">
                             <h2 class="title mb-40" data-aos="fade-up" data-aos-delay="100">
                                 {!! @$affordable_deals->section_title !!}
                             </h2>
                         </div>
                     </div>
                 </div>
                 <div class="row justify-content-center">
                     @php
                         $colors = ['#F5F3FB', '#FBF6F3', '#F3FBF6'];
                     @endphp

                     @if (count($affordable_products) > 0)
                         @foreach ($affordable_products as $index => $affordable_product)
                             @php
                                 $bgColor = $colors[$index % count($colors)];
                             @endphp

                             <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                                 <div class="pricing-card mb-30" style="--bg-color: {{ $bgColor }};">
                                     <div class="pricing-border"></div>

                                     <h3>{{ convertUtf8($affordable_product->title) }}</h3>

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

                                     <div class="mb-40">
                                         {!! \Illuminate\Support\Str::limit(strip_tags($affordable_product->summary), 100) !!}
                                     </div>

                                     <div class="product-image mb-10">
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
             <div class="shape-area">
                 <div class="shape-1" data-aos="fade-right" data-aos-delay="500">
                     <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                         data-src="{{ !empty($affordable_deals->left_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $affordable_deals->left_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                         alt="shape">
                 </div>
                 <div class="shape-2" data-aos="fade-left" data-aos-delay="500">
                     <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                         data-src="{{ !empty($affordable_deals->right_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $affordable_deals->right_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                         alt="shape">
                 </div>
             </div>
         </section>
