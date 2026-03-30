@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="category-area category-3 bg-primary ptb-100 bg-img"
    data-bg-image="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->feature_section_bg_image, $userBs)}}" style="">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-center mb-50" data-aos="fade-up">
                    <h2 class="title mb-0 color-white">{{ convertUtf8($userBs->feature_title) }}</h2>
                </div>
            </div>
            <div class="col-12" data-aos="fade-up">
                <div class="row">

                    @forelse ($features as $feature)
                        <div class="col-xl-2 col-lg-3 col-6">
                            <div class="card text-center bg-dark p-20 mb-25">
                                <div class="card-icon mb-20">
                                    <img class="lazyload blur-up"
                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_FEATURE_IMAGES, $feature->image, $userBs)}}"
                                        alt="Image">
                                </div>
                                <h6 class="card-title color-white lc-1 mb-0">
                                    <a target="_self"
                                        title="{{ convertUtf8($feature->title) }}">{{ convertUtf8($feature->title) }}</a>
                                </h6>
                            </div>
                        </div>
                    @empty
                        <h2> {{ __('No Features') }} </h2>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
    <!-- Bg shape -->
    @if ($userBs->features_section_top_shape_image)
        <div class="bg-shape">
            <img class="lazyload" data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->features_section_top_shape_image, $userBs) }}"
                alt="Bg Shape">
        </div>
    @endif
    @if ($userBs->features_section_bottom_shape_image)
        <div class="bg-shape h-auto">
            <img class="lazyload" data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->features_section_bottom_shape_image, $userBs) }}"
                alt="Bg Shape">
        </div>
    @endif
</section>
