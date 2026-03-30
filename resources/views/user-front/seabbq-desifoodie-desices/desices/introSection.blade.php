    @php
        use App\Constants\Constant;
        use App\Http\Helpers\Uploader;
        use Illuminate\Support\Facades\Auth;

    @endphp
    <!-- ======= START About section ========= -->
    <section class="about-section pb-lg-90 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-6" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="title mb-24">
                        {{ @$userBs->intro_title }}
                    </h2>
                    <p class="desc mb-lg-40 mb-30">
                        {!! @$userBs->intro_text !!}
                    </p>

                    <div class="row">
                        @foreach ($intro_feature_items as $intro_feature_item)
                            <div class="col-md-5">
                                <div class="about-sm-card mb-30">
                                    <img class="img-to-svg vactor"
                                        src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/about/sm-card-vactor.svg') }}"
                                        alt="vactor">
                                    <div class="icon mb-lg-40 mb-30">
                                        <img src="{{ $intro_feature_item->image ? Uploader::getImageUrl(Constant::WEBSITE_INTRO_POINTER_IMAGE, $intro_feature_item->image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                                            alt="icon">
                                    </div>
                                    <h4><a href="javascript:void(0)">{{ convertUtf8($intro_feature_item->title) }}</a>
                                    </h4>
                                    <span>{{ convertUtf8($intro_feature_item->text) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-xl-6">
                    <div class="about-image mb-30" data-aos="fade-left" data-aos-delay="100">
                        <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                            data-src="{{ $userBs->intro_main_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_main_image, $userBs) : asset('assets/admin/img/noimage.jpg') }}"
                            alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= End About section ========= -->
