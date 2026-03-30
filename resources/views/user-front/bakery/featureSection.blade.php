@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="category-area category-1 pb-100 bg-img"
    data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->feature_section_bg_image, $userBs) }}">
    <div class="overlay opacity-50"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-center mb-50" data-aos="fade-up">
                    <h2 class="title mb-0">{{ convertUtf8($userBs->feature_title) }}</h2>
                </div>
            </div>
            <div class="col-12" data-aos="fade-up">
                <div class="swiper category-slider" id="category-slider-1" data-slides-per-view="4"
                    data-swiper-loop="true">
                    <div class="swiper-wrapper">

                        @foreach ($features as $feature)
                            <div class="swiper-slide">
                                <div class="card text-center p-40 rounded-circle">
                                    <div class="card-image mb-10 mx-auto">
                                        <span target="_self" title="{{ convertUtf8($feature->title) }}"
                                            class="lazy-container ratio ratio-1-1 bg-none">
                                            @if (!empty($feature->image))
                                                <img class="lazyload"
                                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $userBs) }}"
                                                    alt="Image">
                                            @endif
                                        </span>
                                    </div>
                                    <h6 class="card-title lc-1 mb-0"><span target="_self"
                                            title="{{ convertUtf8($feature->title) }}">{{ convertUtf8($feature->title) }}</span>
                                    </h6>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination position-static mt-40" id="category-slider-1-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
