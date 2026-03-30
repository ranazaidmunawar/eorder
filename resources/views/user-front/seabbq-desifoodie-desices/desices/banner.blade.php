   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;
   @endphp
   <!-- ======= START banner section ========= -->
   <section class="banner-section pt-lg-120 pt-70">
       <div class="container">
           <div class="row">
               <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
                   <div class="banner-card-sm mb-30">
                       <img class="card-img"
                           src="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, @$left_banner->image, $userBs) }}"
                           alt="frame">
                       <div class="card-text">
                           <span class="subtitle mb-10">{{ @$left_banner->title }}</span>
                           <h3 class="title lc-3 mb-10">
                               <a href="{{ @$left_banner->button_url }}">{{ @$left_banner->subtitle }}</a>
                               </h2>
                               <p class="desc small mb-30">{{ @$left_banner->text }}</p>
                               @if (isset($left_banner->button_url) && isset($left_banner->button_text))
                                   <a href="{{ @$left_banner->button_url }}"
                                       class="btn thm-btn radius-30">{{ @$left_banner->button_text }}</a>
                               @endif
                       </div>
                   </div>
               </div>
               <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                   <div class="banner-md-vertical mb-30 bg-cover bg-img"
                       data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_BANNER_IMAGE, @$right_banner->image, $userBs) }}">
                       <div class="card-text">
                           <span class="subtitle mb-10">{{ @$right_banner->title }}</span>
                           <h2 class="title lc-3 mb-10">
                               <a href="{{ @$right_banner->button_url }}">{{ @$right_banner->subtitle }}</a>
                           </h2>
                           <p class="desc mb-30">{{ @$right_banner->text }}</p>
                           @if (isset($right_banner->button_url) && isset($right_banner->button_text))
                               <a href="{{ @$right_banner->button_url }}"
                                   class="btn thm-btn radius-30">{{ @$right_banner->button_text }}</a>
                           @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- ======= End banner section ========= -->
