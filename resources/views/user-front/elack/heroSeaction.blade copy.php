@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="hero-banner hero-banner-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">

                <div class="banner-content mw-100">

                    @if ($userBe->hero_section_bold_text)
                        <h1 class="title color-white mb-30 mt-1" data-aos="fade-up" data-aos-delay="100"
                            style="color: #{{ $userBe->hero_section_bold_text_color }} !important; font-size :{{ $userBe->hero_section_bold_text_font_size }}px !important">
                            {{ $userBe->hero_section_bold_text }}
                        </h1>
                    @endif
                    @if ($userBe->hero_section_text)
                        <p class="text color-light" data-aos="fade-up" data-aos-delay="100"
                            style="color: #{{ $userBe->hero_section_text_color }} !important; font-size :{{ $userBe->hero_section_text_font_size }}px !important">
                            {{ $userBe->hero_section_text }}
                        </p>
                    @endif


                    <div class="cta-btn mt-30 btn-groups justify-content-center" data-aos="fade-up"
                        data-aos-delay="250">
                        @if ($userBe->hero_section_button_url)
                            <a href="{{ $userBe->hero_section_button_url }}" class="btn btn-lg btn-primary rounded-pill"
                                title="{{ convertUtf8($userBe->hero_section_button_text) }}" target="_self"
                                style="background-color:#{{ $userBe->hero_section_button_color }};border: 2px solid #{{ $userBe->hero_section_button_color }};font-size: {{ $userBe->hero_section_button_text_font_size }}px;">{{ convertUtf8($userBe->hero_section_button_text) }}</a>
                        @endif
                        @if ($userBe->hero_section_button2_url)
                            <a href="{{ $userBe->hero_section_button2_url }}"
                                class="btn btn-lg btn-outline rounded-pill"
                                title="{{ $userBe->hero_section_button2_text }}" target="_self"
                                style="background-color:#{{ $userBe->hero_section_button_two_color }};font-size: {{ $userBe->hero_section_button2_text_font_size }}px;">{{ $userBe->hero_section_button2_text }}</a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Bg image -->
    @if ($userBe->hero_bg)
        <div class="bg-img"
            data-bg-image="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bg, $userBs) : '' }}">
        </div>
    @endif

    
    <!-- Bg shape -->
    @if ($userBe->hero_shape_img)
        <div class="bg-shape h-auto">
            <img class="lazyload"
                data-src="{{ $userBe->hero_shape_img ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_shape_img, $userBs) : '' }}"
                alt="Bg Shape">
        </div>
    @endif
</section>
