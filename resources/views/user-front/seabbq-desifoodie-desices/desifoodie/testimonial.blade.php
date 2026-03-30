     @php
         use App\Constants\Constant;
         use App\Http\Helpers\Uploader;
         use Illuminate\Support\Facades\Auth;

     @endphp
     <!-- ======= START testimonial section ========= -->
     <section class="testimonial-area pt-lg-120 pt-60 pb-lg-70 pb-30">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="text-center">
                         <h2 class="title mb-40 " data-aos="fade-up" data-aos-delay="150">
                             {{ @$userBs->testimonial_title }}
                         </h2>
                     </div>
                 </div>
             </div>
         </div>
         <div class="testimonial-slider-wrap" data-aos="fade-up" data-aos-delay="150">
             <div class="swiper testimonial-slider-v2">
                 <div class="swiper-wrapper">
                     @foreach ($testimonials as $testimonial)
                         <div class="swiper-slide bg-img bg-cover"
                             data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->background_image, $userBs) }}">
                             <div class="testimonial-item">
                                 <div class="testimonial-body">
                                     <p>{{ convertUtf8($testimonial->comment) }}</p>
                                 </div>
                                 <div class="testimonial-item-bottom">
                                     <div class="customer-info">
                                         <div class="image">
                                             <img class="blur-up lazyload" src="assets/images/testimonial/user-1.png"
                                                 data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                 alt="user">
                                         </div>
                                         <div class="customer-content">
                                             <h6 class="mb-0 body-font fw-medium"><a
                                                     href="javascript:void(0)">{{ convertUtf8($testimonial->name) }}</a>
                                             </h6>
                                             <span class="small">{{ convertUtf8($testimonial->rank) }}</span>
                                         </div>
                                     </div>

                                     <div class="rateing-wrap">
                                         @php
                                             $rating = max(0, min(5, $testimonial->rating));
                                             $ratingPercent = ($rating / 5) * 100;
                                         @endphp

                                         <div class="rate">
                                             <div class="rating-icon" style="width: {{ $ratingPercent }}%;"></div>
                                         </div>

                                         <span class="small fw-normal mt-1">
                                             {{ $testimonial->rating }}
                                             {{ $keywords['star_of'] ?? 'star of' }}
                                             {{ count($testimonials) }}
                                             {{ count($testimonials) == 1 ? $keywords['review'] ?? 'review' : $keywords['reviews'] ?? 'reviews' }}
                                         </span>
                                     </div>

                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>
                 <div class="testimonial-slider-pagination"></div>
             </div>
         </div>
     </section>
     <!-- ======= End testimonial section ========= -->
