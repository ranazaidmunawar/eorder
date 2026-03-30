@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="about-area about-3 pt-100 pb-60 parallax">
    <!-- Spacer -->
    <div class="container">
        <div class="row align-items-center gx-xl-5">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="image mb-40 parallax-img img-left" data-speed="0.1" data-revert="true">
                    @if ($userBs->intro_main_image)
                        <img class="lazyload blur-up" data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE,$userBs->intro_main_image,$userBs) }}"
                            alt="Image">
                    @endif
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up">
                <div class="content-title mb-40 ps-xl-2">
                    <h2 class="title mb-30">
                        {{ convertUtf8($userBs->intro_title) }}
                    </h2>
                    <div class="content-text">
                        <p>
                            {{ convertUtf8($userBs->intro_text) }}
                        </p>

                    </div>
                    @if ($intro_feature_items->count() > 0)
                        <div class="info-list mt-30">
                            <div class="row">
                                @foreach ($intro_feature_items as $item)
                                    <div class="col-sm-4 item mb-30">
                                        <div class="card">
                                            <div class="card-content">
                                                <span class="h3 font-medium mb-2"><span
                                                        class="counter">{{ $item->intro_section_rating_point }}</span>{{ $item->intro_section_rating_symbol }}</span>
                                                <p class="card-text font-lg lh-1"> {{ $item->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    @endif

                    <div class="btn-groups gap-25 mt-10" data-aos="fade-up">
                        @if ($userBs->intro_section_button_url)
                            <a href="{{ $userBs->intro_section_button_url }}" class="btn btn-lg btn-primary"
                                title="{{ $userBs->intro_section_button_text }}" target="_self"
                                style="background-color:#{{ $userBs->base_color }} !important; border: 2px solid #{{ $userBs->base_color }} !important ;">{{ $userBs->intro_section_button_text }}</a>
                        @endif

                        @if ($userBs->intro_video_link)
                            <a href="{{ $userBs->intro_video_link }}"
                                class="video-btn video-btn-text video-btn-sm youtube-popup" target="_self"
                                title="Show Video">
                                <i class="fas fa-play"></i>
                                <span>{{ $userBs->intro_section_video_button_text }}</span>
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
