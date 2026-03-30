     @php
         use App\Constants\Constant;
         use App\Http\Helpers\Uploader;
         use Illuminate\Support\Facades\Auth;

     @endphp
     <div class="testimonial-extra-space">
         <section class="testimonial-area bg-cover bg-img"
             data-bg-image="{{ !empty($userBe->testimonial_bg_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->testimonial_bg_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}">
             <div class="overlay"></div>
             <div class="container">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="text-center">
                             <h2 class="title text-white" data-aos="fade-up" data-aos-delay="150">
                                 {!! $userBs->testimonial_title !!}
                             </h2>
                         </div>
                     </div>
                 </div>

                 <div class="testimonial-slider-area">
                     <div class="second-round">
                         <div class="third-round">
                             <div class="testimonial-slider-wrap">
                                 <div class="swiper testimonial-slider">
                                     <div class="swiper-wrapper">
                                         @foreach ($testimonials as $testimonial)
                                             <div class="swiper-slide">
                                                 <div class="testimonial-item">
                                                     <div class="testimonial-item-top">
                                                         <div class="customer-info">
                                                             <div class="image">
                                                                 <img class="blur-up lazyload"
                                                                     src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                                     data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                                     alt="user">
                                                             </div>
                                                             <div class="customer-content">
                                                                 <h6 class="mb-0 body-font fw-medium"><a
                                                                         href="javascript:void(0)">{{ convertUtf8($testimonial->name) }}</a>
                                                                 </h6>
                                                                 <span
                                                                     class="small">{{ convertUtf8($testimonial->rank) }}</span>
                                                             </div>
                                                         </div>

                                                         <div class="rateing-wrap">
                                                             @php
                                                                 $rating = max(0, min(5, $testimonial->rating));
                                                                 $ratingPercent = ($rating / 5) * 100;
                                                             @endphp

                                                             <div class="rate">
                                                                 <div class="rating-icon"
                                                                     style="width: {{ $ratingPercent }}%;"></div>
                                                             </div>

                                                             <span class="small fw-normal mt-1">
                                                                 {{ $testimonial->rating }}
                                                                 {{ $keywords['star_of'] ?? 'star of' }}
                                                                 {{ count($testimonials) }}
                                                                 {{ count($testimonials) == 1 ? $keywords['review'] ?? 'review' : $keywords['reviews'] ?? 'reviews' }}
                                                             </span>
                                                         </div>

                                                     </div>
                                                     <div class="testimonial-body">
                                                         <span class="quote">
                                                             <img class="img-to-svg" src="assets/images/quote-down.svg"
                                                                 alt="">
                                                         </span>
                                                         <p> {{ convertUtf8($testimonial->comment) }}</p>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endforeach
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="testimonial-slider-pagination"></div>
                 </div>

             </div>
             <div class="shape-area">
                 <div class="shape-1" data-aos="fade-right" data-aos-delay="500">
                     <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                         data-src="{{ !empty($userBe->testimonial_left_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->testimonial_left_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                         alt="shape">
                 </div>
                 <div class="shape-2" data-aos="fade-left" data-aos-delay="500">
                     <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                         data-src="{{ !empty($userBe->testimonial_right_shape_image) ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->testimonial_right_shape_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                         alt="shape">
                 </div>
             </div>
         </section>
     </div>
