   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;

   @endphp
   <!-- ======= START HERO section ========= -->
   <section class="hero-area  bg-cover bg-img" data-bg-image="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bg, $userBs) : '' }}">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="content mb-30">
                       <h1 class="title mb-18" data-aos="fade-up" data-aos-delay="100">
                           {{ $userBe->hero_section_title ?? 'Hero Section Title' }}
                       </h1>
                       <p class="desc mb-lg-40 mb-30" data-aos="fade-up" data-aos-delay="200">
                           {{ $userBe->hero_section_text ?? 'Hero Section Text' }}
                       </p>
                       <div class="d-flex gap-3 flex-wrap justify-content-center" data-aos="fade-up"
                           data-aos-delay="300">
                           @if (!is_null($userBe->hero_section_button_text1_url) && !is_null($userBe->hero_section_button_text))
                               <a href="{{ $userBe->hero_section_button_text1_url }}" class="btn radius-30 thm-btn">
                                   {{ $userBe->hero_section_button_text }}
                               </a>
                           @endif
                           @if (!is_null($userBe->hero_section_button2_url) && !is_null($userBe->hero_section_button2_text))
                               <a href="{{ $userBe->hero_section_button2_url }}" class="btn radius-30 thm-btn-light">
                                   {{ $userBe->hero_section_button2_text }}
                               </a>
                           @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="shape-area">
           <div class="shape-1">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ $userBe->left_top_shape ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->left_top_shape, $userBs) : '' }}" alt="image">
           </div>
           <div class="shape-2">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ $userBe->left_bottom_shape ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->left_bottom_shape, $userBs) : '' }}" alt="image">
           </div>
           <div class="shape-3">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ $userBe->right_top_shape ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->right_top_shape, $userBs) : '' }}" alt="image">
           </div>
           <div class="shape-4">
               <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                   data-src="{{ $userBe->right_bottom_shape ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->right_bottom_shape, $userBs) : '' }}" alt="image">
           </div>
       </div>
   </section>
   <!-- ========= END HERO section ========= -->
