        @php
            use App\Constants\Constant;
            use App\Http\Helpers\Uploader;
            use Illuminate\Support\Facades\Auth;
        @endphp
        <!-- ======= START categori section ========= -->
        <section class="categori-section pt-lg-100 pt-60 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h2 class="title mb-20" data-aos="fade-up" data-aos-delay="150">
                                {{ $userBe->featured_category_section_title ?? 'Top Desi Food Categories' }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- categori slider -->
            <div data-aos="fade-up" data-aos-delay="200">
                <div class="categori-slider-area">
                    <div class="swiper categori-slider default-slider pt-20 pb-70" id="default-slider-categori"
                        data-slidespace="20" data-loop="true" data-center="true" data-xsmview="1" data-smview="2"
                        data-mdview="4" data-lgview="5" data-xlview="6">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                @php
                                    $totalProduct = $category
                                        ->productInformation()
                                        ->where('language_id', $userCurrentLang->id)
                                        ->count();
                                @endphp
                                <div class="swiper-slide">
                                    <div class="categori-card"
                                        onclick="window.location.href='{{ route('user.front.items', [getParam(), 'category' => $category->slug]) }}'">
                                        <div class="content">
                                            <h4><a
                                                    href="{{ route('user.front.items', [getParam(), 'category' => $category->slug]) }}">{{ $category->name }}</a>
                                            </h4>
                                            <span>
                                                {{ $totalProduct }}
                                                @if ($totalProduct > 1)
                                                    {{ $keywords['Products_Available'] ?? 'Products Available' }}
                                                @else
                                                    {{ $keywords['Product_Available'] ?? 'Product Available' }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="categori-image">
                                            <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_PRODUCT_CATEGORY_IMAGE, $category->image, $userBs) }}"
                                                alt="categori-image">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination" id="default-slider-categori-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= end categori section ========= -->
