   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;

   @endphp
   <!-- ======= START HERO section ========= -->
   <section class="hero-area header-next">
       <div class="container">
           <div class="row">
               <div class="col-lg-6">
                   <div class="content mb-30">
                       <h1 class="title mb-20" data-aos="fade-up" data-aos-delay="100">
                           {{ $userBe->hero_section_title ??'Hero Section Title' }}
                       </h1>
                       <p class="mb-lg-30 mb-30" data-aos="fade-up" data-aos-delay="200">
                           {{ $userBe->hero_section_text ?? 'Hero Section Text' }}
                       </p>
                       <div class="d-flex gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="300">
                           @if (!is_null($userBe->hero_section_button_text1_url) && !is_null($userBe->hero_section_button_text))
                               <a href="{{ $userBe->hero_section_button_text1_url }}"
                                   class="btn thm-btn">{{ $userBe->hero_section_button_text }}</a>
                           @endif
                           @if (!is_null($userBe->hero_section_button2_url) && !is_null($userBe->hero_section_button2_text))
                               <a href="{{ $userBe->hero_section_button2_url }}"
                                   class="btn thm-btn-light">{{ $userBe->hero_section_button2_text }}</a>
                           @endif
                       </div>
                   </div>
               </div>
               <div class="col-lg-6">
                   <div class="hero-image" data-aos="fade-left" data-aos-delay="100">
                       <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                           data-src="{{ $userBe->hero_side_img ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_side_img, $userBs) : '' }}"
                           alt="image">
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!-- ========= END HERO section ========= -->
