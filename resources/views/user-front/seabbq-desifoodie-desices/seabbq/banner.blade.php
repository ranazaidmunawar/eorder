   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;
   @endphp
   <section class="banner-section">
       <div class="container">
           <div class="row">
               <div class="col-lg-6">
                   <div class="banner-md-card mb-30" data-aos="fade-up" data-aos-delay="100">
                       <img class="card-img lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                           data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, @$left_banner->image, $userBs) }}"
                           alt="product">
                       <div class="card-text">
                           <p class="subtitle">{{ @$left_banner->title }}</p>
                           <h3 class="title lc-2"><a
                                   href="{{ @$left_banner->button_url }}">{{ @$left_banner->subtitle }}</a></h3>
                           <a href="{{ @$left_banner->button_url }}"
                               class="btn thm-btn-light radius-30">{{ @$left_banner->button_text }}</a>
                       </div>
                   </div>
               </div>
               <div class="col-lg-6">
                   <div class="banner-md-card mb-30" data-aos="fade-up" data-aos-delay="100">
                       <img class="card-img lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                           data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, @$right_banner->image, $userBs) }}"
                           alt="product">
                       <div class="card-text">
                           <p class="subtitle">{{ @$right_banner->title }}</p>
                           <h3 class="title lc-2"><a
                                   href="{{ @$right_banner->button_url }}">{{ @$right_banner->subtitle }}
                               </a></h3>
                           <a href="{{ @$right_banner->button_url }}"
                               class="btn thm-btn-light radius-30">{{ @$right_banner->button_text }}</a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
