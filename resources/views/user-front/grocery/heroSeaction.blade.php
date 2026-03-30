@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="hero-banner hero-banner-5">
    <div class="container">
        <div class="row align-items-center gx-xl-5">
            <div class="col-lg-6">
                <div class="banner-content mb-40">
                    @if ($userBe->hero_section_bold_text)
                        <h1 class="title mb-30" data-aos="fade-up" data-aos-delay="100"
                            style="color: #{{ $userBe->hero_section_bold_text_color }} !important; font-size :{{ $userBe->hero_section_bold_text_font_size }}px !important">
                            {{ $userBe->hero_section_bold_text }}
                        </h1>
                    @endif
                    @if ($userBe->hero_section_text)
                        <p class="text color-dark" data-aos="fade-up" data-aos-delay="100"
                            style="color: #{{ $userBe->hero_section_text_color }} !important; font-size :{{ $userBe->hero_section_text_font_size }}px !important">
                            {{ $userBe->hero_section_text }}
                        </p>
                    @endif
                    <div class="cta-btn mt-40 btn-groups" data-aos="fade-up" data-aos-delay="250">

                        @if ($userBe->hero_section_button_url)
                            <a href="{{ $userBe->hero_section_button_url }}" class="btn btn-lg btn-primary "
                                title="{{ convertUtf8($userBe->hero_section_button_text) }}" target="_self"
                                style="background: #{{ $userBe->hero_section_button_color }}; font-size: {{ $userBe->hero_section_button_text_font_size }}px; border:1px solid #{{ $userBe->hero_section_button_color }}!important">{{ convertUtf8($userBe->hero_section_button_text) }}</a>
                        @endif

                        @if ($userBe->hero_section_button2_url)
                            <a href="{{ $userBe->hero_section_button2_url }}" class="btn btn-lg btn-outline  border-0"
                                title="{{ $userBe->hero_section_button2_text }}" target="_self"
                                style="background: #{{ $userBe->hero_section_button_two_color }}; font-size: {{ $userBe->hero_section_button2_text_font_size }}px; border:1px solid #{{ $userBe->hero_section_button_two_color }} !important">{{ $userBe->hero_section_button2_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($userBe->hero_bg)
        <div class="bg-img" data-bg-image="{{ $userBe->hero_bg ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->hero_bg, $userBs) : '' }}"></div>
    @endif
</section>
