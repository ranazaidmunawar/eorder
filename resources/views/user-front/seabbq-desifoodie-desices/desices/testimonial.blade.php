     @php
         use App\Constants\Constant;
         use App\Http\Helpers\Uploader;
         use Illuminate\Support\Facades\Auth;

     @endphp
     <!-- ======= START testimonial section ========= -->
     <section class="testimonial-area pt-lg-100 pt-50 pb-lg-70 pb-30">
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
             <div class="testimonial-slider-wrap" data-aos="fade-up" data-aos-delay="150">
                 <div class="swiper default-slider pt-20 pb-70" id="default-slider-testimonial" data-slidespace="20"
                     data-xsmview="1" data-smview="1" data-mdview="2" data-lgview="2" data-xlview="3">
                     <div class="swiper-wrapper">
                         @foreach ($testimonials as $testimonial)
                             <div class="swiper-slide">
                                 <div class="testimonial-item">
                                     <div class="testimonial-item-top">
                                         <div class="customer-info">
                                             <div class="image">
                                                 <img class="blur-up lazyload"
                                                     data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                     alt="user">
                                             </div>
                                             <div class="customer-content">
                                                 <h6 class="mb-0 body-font fw-medium">
                                                     <a
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
                                     <div class="testimonial-body">
                                         <div>{{ convertUtf8($testimonial->comment) }}</div>
                                     </div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                     <div class="swiper-pagination" id="default-slider-testimonial-pagination"></div>
                 </div>
             </div>
         </div>
     </section>
     <!-- ======= End testimonial section ========= -->
