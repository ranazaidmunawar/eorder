    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use Illuminate\Support\Facades\Auth;

    @endphp
    <section class="about-section pt-lg-130 pt-60 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <h2 class="title mb-24 " data-aos="fade-up" data-aos-delay="100">
                        {!! $userBs->intro_title !!}
                    </h2>
                    <p class="mb-lg-40 mb-30" data-aos="fade-up" data-aos-delay="20">
                        {{ convertUtf8($userBs->intro_text) }}
                    </p>
                    <ul class="reset-ul info-list" data-aos="fade-up" data-aos-delay="300">
                        @foreach ($intro_feature_items as $intro_feature_item)
                            <li>
                                <div class="icon" style="--bg-color: #{{ $intro_feature_item->background_color }};">
                                    <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                        data-src="{{ $intro_feature_item->image ? Uploader::getImageUrl(Constant::WEBSITE_INTRO_POINTER_IMAGE, $intro_feature_item->image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                        alt="icon">
                                </div>
                                <div class="content">
                                    <h3>{{ convertUtf8($intro_feature_item->title) }}</h3>
                                    <p>{{ convertUtf8($intro_feature_item->text) }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-xl-6">
                    <div class="about-image" data-aos="fade-left" data-aos-delay="100">
                        <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_right_side_image, $userBs) }}"
                            alt="image">
                    </div>
                </div>
            </div>
        </div>
        <div class="shape" data-aos="fade-right" data-aos-delay="500">
            <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_left_side_image, $userBs) }}"
                alt="shape-1">
        </div>
    </section>
