@extends('front.layout')

@section('meta-description', !empty($seo) ? $seo->about_us_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->about_us_meta_keywords : '')

@section('pagename')
    - {{ __('About Us') }}
@endsection
@section('breadcrumb-title')
    {{ __('About Us') }}
@endsection
@section('breadcrumb-link')
    {{ __('About Us') }}
@endsection

@section('content')
 <div class=" pt-120 pb-90">
    <section class="choose-area pb-90">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="choose-content mb-30" data-aos="fade-right">
                        <span class="subtitle">{{ $bs->intro_title }}</span>
                        <h2 class="title">{{ $bs->intro_subtitle }}</h2>
                        <p class="text">{!! nl2br($bs->intro_text) !!}</p>
                        <div class="d-flex align-items-center">
                            @if ($bs->intro_section_button_url)
                                <a href="{{ $bs->intro_section_button_url }}" class="btn primary-btn">
                                    {{ $bs->intro_section_button_text }}
                                </a>
                            @endif
                            @if ($bs->intro_section_video_url)
                                <a href="{{ $bs->intro_section_video_url }}" class="btn video-btn youtube-popup"><i
                                        class="fas fa-play"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row justify-content-center">
                        @foreach ($features as $feature)
                            <div class="col-xl-4 col-sm-6" data-aos="fade-up">
                                <div class="card mb-30">
                                    <div class="card-icon">
                                        <img src="{{ asset('assets/front/img/features/' . $feature->image) }}"
                                            alt="Icon">
                                    </div>
                                    <div class="card-content">
                                        <a href="javascript:void(0);">
                                            <h5 class="card-title">{{ $feature->title }}</h5>
                                        </a>
                                        <p class="card-text">{{ $feature->text }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="shape">
            <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-5.png') }}" alt="Shape">
            <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
            <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-7.png') }}" alt="Shape">
        </div>
    </section>

     <section class="store-area pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title title-inline" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="title mb-0">{{ $bs->work_process_title }}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        @if ($processes->count() > 0)
                            @foreach ($processes as $process)
                                <div class="col-sm-6 col-lg-6 col-xl-3" data-aos="fade-up">
                                    <div class="card mb-30">
                                        <div class="card-icon">
                                            <i class="{{ $process->icon }}"></i>
                                        </div>
                                        <div class="card-content">
                                           
                                                <h3 class="card-title">{{ $process->title }}</h3>
                                           
                                            <p class="card-text">{{ $process->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-center py-2" data-aos="fade-up" data-aos-delay="100">
                                {{ __('No Data Found!') }}
                            </h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="shape">
            <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
            <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-3.png') }}" alt="Shape">
            <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-9.png') }}" alt="Shape">
        </div>
    </section>

    <section class="testimonial-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title ms-0" data-aos="fade-right">
                        <h2 class="title">{{ $bs->testimonial_title }}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row align-items-center gx-xl-5">
                        <div class="col-lg-6">
                            <div class="image image-left mb-30" data-aos="fade-right">
                                <img src="{{ asset('assets/front/img/testimonials/' . $be->testimonial_img) }}"
                                    alt="Image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="swiper testimonial-slider" data-aos="fade-left">
                                <div class="swiper-wrapper">
                                    @for ($i = 0; $i <= count($testimonials); $i = $i + 2)
                                        @if ($i < count($testimonials) - 1)
                                            <div class="swiper-slide">
                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            {{ $testimonials[$i]->comment }}
                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                    data-src="{{ $testimonials[$i]->image ? asset('assets/front/img/testimonials/' . $testimonials[$i]->image) : asset('assets/restaurant/images/client/client-1.jpg') }}"
                                                                    alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name">{{ $testimonials[$i]->name }}</h6>
                                                            <span class="designation">{{ $testimonials[$i]->rank }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="slider-item">
                                                    <div class="quote">
                                                        <span class="icon"><i class="fas fa-quote-right"></i></span>
                                                        <p class="text">
                                                            {{ $testimonials[$i + 1]->comment }}
                                                        </p>
                                                    </div>
                                                    <div class="client">
                                                        <div class="image">
                                                            <div class="lazy-container aspect-ratio-1-1">
                                                                <img class="lazyload lazy-image"
                                                                    data-src="{{ $testimonials[$i + 1]->image ? asset('assets/front/img/testimonials/' . $testimonials[$i + 1]->image) : asset('assets/restaurant/images/client/client-1.jpg') }}"
                                                                    alt="Person Image">
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name">{{ $testimonials[$i + 1]->name }}</h6>
                                                            <span
                                                                class="designation">{{ $testimonials[$i + 1]->rank }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                                <div class="swiper-pagination" id="testimonial-slider-pagination" data-min data-max>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shape">
            <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
            <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-9.png') }}" alt="Shape">
            <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-10.png') }}" alt="Shape">
            <img class="shape-4" src="{{ asset('assets/restaurant/images/shape/shape-4.png') }}" alt="Shape">
        </div>
    </section>

</div> 

@endsection
