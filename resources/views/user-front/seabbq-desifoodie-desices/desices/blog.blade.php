        @php
            use App\Constants\Constant;
            use App\Http\Helpers\Uploader;
            use Illuminate\Support\Facades\Auth;
        @endphp
        <!-- ======= START Blog section ========= -->
        <div class="blog-extra-space">
            <section class="section-blog pt-40 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title-inline mb-40">
                                <h2 class="title fw-normal mb-0" data-aos="fade-up" data-aos-delay="100">
                                    {{ @$userBs->blog_section_title }}
                                </h2>
                                <a href="{{ route('user.front.blogs', getParam()) }}"
                                    class="btn thm-btn radius-30">{{ $keywords['Show_All'] ?? 'Show All' }}</a>
                            </div>
                        </div>
                    </div>

                    @if (count($blogs) > 0)
                        <div class="swiper default-slider pb-70" id="default-slider-blog" data-slidespace="20"
                            data-xsmview="1" data-smview="1" data-mdview="2" data-lgview="3" data-xlview="3">
                            <div class="swiper-wrapper">
                                @foreach ($blogs as $blog)
                                    <div class="swiper-slide">
                                        <article class="blog-card mb-30">
                                            <figure class="blog-image mask mb-14">
                                                <a
                                                    href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}">
                                                    <img class="blur-up lazyload" src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/placeholder.svg') }}"
                                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs) }}"
                                                        alt="blog">
                                                </a>
                                            </figure>
                                            <div class="blog-content">
                                                <h4 class="title lc-2 mb-18">
                                                    <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}"
                                                        class="lc-2">
                                                        {{ convertUtf8($blog->title) }}
                                                    </a>
                                                </h4>
                                               <p class="card-text mb-24 lc-3">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($blog->content), 100) !!}
                                                </p>
                                                <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}"
                                                    class="read-more-btn">
                                                    {{ $keywords['Read_More'] ?? __('Read More') }} <i
                                                        class="fa-light fa-arrow-right"></i>
                                                </a>
                                            </div>

                                            <div class="bg-shape">
                                                <img src="{{ asset('assets/restaurant/seabbq-desifoodie-desices/images/blog-12-shape-1.png') }}" alt="">
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination" id="default-slider-blog-pagination"></div>
                        </div>
                    @else
                        <h4 class="text-center">{{ $keywords['No Blog Found'] ?? 'No Blog Found' }}</h4>
                    @endif
                </div>

            </section>
            <div class="shape">
                <img src="{{ $userBs->blog_section_bg_image ? Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->blog_section_bg_image, $userBs) : '' }}" alt="image">
            </div>
        </div>
        <!-- ======= End Blog section ========= -->
