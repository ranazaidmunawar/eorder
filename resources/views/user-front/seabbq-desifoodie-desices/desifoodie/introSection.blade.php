    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use Illuminate\Support\Facades\Auth;

    @endphp
    <!-- ======= START About section ========= -->
    <section class="about-section">
        <div class="container">
            <div class="row about-row">
                <div class="col-xl-6">
                    <div class="about-image mb-30" data-aos="fade-right" data-aos-delay="100">
                        <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                            data-src="{{ $userBs->intro_main_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_main_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                            alt="image">
                    </div>
                </div>
                <div class="col-xl-6">
                    <h2 class="title mb-24 " data-aos="fade-up" data-aos-delay="100">
                        {{ @$userBs->intro_title }}
                    </h2>
                    <p class="mb-lg-40 mb-30" data-aos="fade-up" data-aos-delay="200">
                        {!! @$userBs->intro_text !!}
                    </p>

                    <div data-aos="fade-up" data-aos-delay="300">
                        <!-- Real Slider -->
                        <div class="swiper real-slider">
                            <div class="swiper-wrapper">
                                @foreach ($intro_feature_items as $intro_feature_item)
                                    <div class="swiper-slide">
                                        <div class="real-slide-item">
                                            <div class="real-slide-image lazy-container ratio ratio-1-1">
                                                <img class="lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                    data-src="{{ $intro_feature_item->image ? Uploader::getImageUrl(Constant::WEBSITE_INTRO_POINTER_IMAGE, $intro_feature_item->image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                                    alt="image">
                                            </div>
                                            <h6 class="body-font fw-semibold">
                                                {{ convertUtf8($intro_feature_item->title) }}</h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Navigation buttons -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= End About section ========= -->
