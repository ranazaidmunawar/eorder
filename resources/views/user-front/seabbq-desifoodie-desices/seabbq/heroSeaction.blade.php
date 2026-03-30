   @php
       use App\Constants\Constant;
       use App\Http\Helpers\Uploader;
       use Illuminate\Support\Facades\Auth;

   @endphp
   <!-- ======= START HERO section ========= -->
   <section class="hero-area bg-img bg-cover"
       data-bg-image="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bg, $userBs) : '' }}">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="content px-2">
                       <h1 class="title mb-40 " data-aos="fade-up" data-aos-delay="100">
                           {!! $userBe->hero_section_title !!}
                       </h1>
                       <div class="d-flex gap-3 flex-wrap justify-content-center" data-aos="fade-up"
                           data-aos-delay="200">
                           @if ($userBe->hero_section_button_text && $userBe->hero_section_button_text1_url)
                               <a href="{{ $userBe->hero_section_button_text1_url }}" class="btn thm-btn radius-30">
                                   {{ $userBe->hero_section_button_text }}
                               </a>
                           @endif
                           @if ($userBe->hero_section_button2_text && $userBe->hero_section_button2_url)
                               <a href="{{ $userBe->hero_section_button2_url }}" class="btn thm-btn-dark radius-30">
                                   {{ $userBe->hero_section_button2_text }}
                               </a>
                           @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="vactor">
           <div class="shape-1" data-aos="fade-right" data-aos-delay="500">
               <img src="{{ $userBe->hero_left_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_left_image, $userBs) : '' }}"
                   alt="left image">
           </div>
           <div class="shape-2" data-aos="fade-left" data-aos-delay="500">
               <img src="{{ $userBe->hero_right_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_right_image, $userBs) : '' }}"
                   alt="right image">
           </div>
       </div>
   </section>
   <!-- ========= END HERO section ========= -->
