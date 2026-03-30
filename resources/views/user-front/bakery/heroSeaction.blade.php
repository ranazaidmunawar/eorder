@php
  use App\Constants\Constant;
  use App\Http\Helpers\Uploader;
  use Illuminate\Support\Facades\Auth;

@endphp
<section class="hero-banner hero-banner-1 parallax pb-100">

    <div class="overlay opacity-80"></div>
    <div class="container-fluid">
        <div class="row align-items-center gx-xl-5">
            <div class="col-lg-6">
                <div class="fluid-left">
                    <div class="banner-content mb-40">
                        @if ($userBe->hero_section_bold_text)
                            <h1 class="title mb-30" data-aos="fade-up" data-aos-delay="100"
                                style="color: #{{ $userBe->hero_section_bold_text_color }};font-size:{{ $userBe->hero_section_bold_text_font_size }}px;">
                                {{ convertUtf8($userBe->hero_section_bold_text) }}</h1>
                        @endif

                        @if ($userBe->hero_section_text)
                            <p class="text" data-aos="fade-up" data-aos-delay="100"
                                style="color: #{{ $userBe->hero_section_text_color }}; font-size: {{ $userBe->hero_section_text_font_size }}px;">
                                {{ convertUtf8($userBe->hero_section_text) }}
                            </p>
                        @endif
                        <div class="d-flex align-items-center gap-25 flex-wrap mt-40" data-aos="fade-up"
                            data-aos-delay="200">
                            @if ($userBe->hero_section_button_url)
                                <a href="{{ $userBe->hero_section_button_url }}" class="btn btn-lg btn-primary rounded-pill"
                                    title="{{ convertUtf8($userBe->hero_section_button_text) }}" target="_self"
                                    style="background: #{{ $userBe->hero_section_button_color }};font-size: {{ $userBe->hero_section_button_text_font_size }}px; border:1px solid #{{ $userBe->hero_section_button_color }}">{{ convertUtf8($userBe->hero_section_button_text) }}</a>
                            @endif

                            @if ($userBe->author_image || $userBe->hero_section_author_name)
                                <div class="author d-flex align-items-center gap-15">
                                    
                                    @if ($userBe->author_image)
                                        <div class="author-img">
                                            <div class="lazy-container rounded-pill ratio ratio-1-1">
                                                <img class="lazyload"
                                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBe->author_image,$userBs) }}"
                                                    alt="Person Image">
                                            </div>
                                        </div>
                                    @endif
                                    @if ($userBe->hero_section_author_name)
                                        <div class="content">
                                            <h6 class="name mb-0 font-sm"><a target="_self"
                                                    title="">{{ convertUtf8($userBe->hero_section_author_name) }}</a>
                                            </h6>
                                            <span
                                                class="designation font-xsm">{{ convertUtf8($userBe->hero_section_author_designation) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @if ($userBe->hero_side_img)
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="banner-image mb-40 parallax-img" data-speed="0.1" data-revert="true">
                        <img class="lazyload blur-up"
                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBe->hero_side_img,$userBs) }}" alt="Banner Image">
                    </div>
                </div>
            @endif

        </div>
    </div>
    @if ($userBe->hero_bg)
        <div class="bg-img" data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBe->hero_bg,$userBs)  }}"></div>
    @endif
</section>
