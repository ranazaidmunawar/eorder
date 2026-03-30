@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="hero-banner hero-banner-4 parallax pb-100">
    <div class="container">
        <div class="row align-items-center gx-xl-5">
            <div class="col-lg-6">
                <div class="banner-content mb-40">

                    @if($userBe->hero_section_bold_text)
                    <h1 class="title mb-30" data-aos="fade-up" data-aos-delay="100"  style="color: #{{ $userBe->hero_section_bold_text_color }} !important; font-size :{{ $userBe->hero_section_bold_text_font_size }}px !important"> {{ $userBe->hero_section_bold_text }}
                    </h1>
                    @endif
                    @if ($userBe->hero_section_text)
                    <p class="text" data-aos="fade-up" data-aos-delay="100"  style="color: #{{ $userBe->hero_section_text_color }} !important; font-size :{{ $userBe->hero_section_text_font_size }}px !important ">
                        {{ $userBe->hero_section_text }}
                    </p>
                    @endif
                    <div class="cta-btn mt-40 btn-groups" data-aos="fade-up" data-aos-delay="250">
                        @if ($userBe->hero_section_button_url)
                        <a href="{{ $userBe->hero_section_button_url }}" class="btn btn-lg btn-primary radius-0" style="background:#{{ $userBe->hero_section_button_color }};border: 2px solid #{{ $userBe->hero_section_button_color }};font-size: {{ $userBe->hero_section_button_text_font_size }}px;" title="{{ convertUtf8($userBe->hero_section_button_text) }}" target="_self">{{ convertUtf8($userBe->hero_section_button_text) }}</a>
                        @endif

                        @if ($userBe->hero_section_button2_url)
                        <a href="{{ $userBe->hero_section_button2_url }}" class="btn btn-lg btn-outline radius-0 bg-white border-0" title="{{ $userBe->hero_section_button2_text }}" target="_self"  style="background:#{{ $userBe->hero_section_button_two_color }} !important; border: 2px solid #{{ $userBe->hero_section_button_two_color }} !important;font-size: {{ $userBe->hero_section_button2_text_font_size }}px !important;">{{ $userBe->hero_section_button2_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
            @if ($userBe->hero_side_img)
            <div class="col-lg-6" data-aos="fade-up">
                <div class="banner-image mb-40 parallax-img" data-speed="0.1" data-revert="true">
                    <img class="lazyload blur-up" data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBe->hero_side_img,$userBs)  }}" alt="Banner Image">
                </div>
            </div>
            @endif
        </div>
    </div>
    @if($userBe->hero_bg)
    <div class="bg-img" data-bg-image="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBe->hero_bg,$userBs)  : '' }}"></div>
    @endif
</section>
