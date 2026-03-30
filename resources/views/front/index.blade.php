@php
    use App\Constants\Constant;
    use App\Models\Package;
@endphp
@extends('front.layout')

@section('pagename')
    - {{ __('Home') }}
@endsection

@section('meta-description', !empty($seo) ? $seo->home_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->home_meta_keywords : '')

@section('content')

    @if ($bs->home_section == 1)

        <section id="home" class="home-banner pb-90">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="fluid-left">
                            <div class="content mb-30" data-aos="fade-down">
                                <span class="subtitle">
                                    {{ $be->hero_section_title }}
                                    <img src="{{ asset('assets/restaurant/images/icon-trophy.png') }}" alt="Icon"></span>
                                <h1 class="title">
                                    {{ $be->hero_section_text }}
                                </h1>
                                <div class="content-botom d-flex align-items-center">
                                    @if ($be->hero_section_button_url)
                                        <a href="{{ $be->hero_section_button_url }}"
                                            class="btn primary-btn">{{ $be->hero_section_button_text }}</a>
                                    @endif
                                    @if ($be->hero_section_video_url)
                                        <a href="{{ $be->hero_section_video_url }}" class="btn video-btn youtube-popup"><i
                                                class="fas fa-play"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="banner-img mb-30" data-aos="fade-right">
                            <img src="{{ asset('assets/front/img/' . $be->hero_img) }}" alt="Banner Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape">
                <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-1.png') }}" alt="Shape">
                <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
                <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-3.png') }}" alt="Shape">
                <img class="shape-4" src="{{ asset('assets/restaurant/images/shape/shape-4.png') }}" alt="Shape">
                <img class="shape-5" src="{{ asset('assets/restaurant/images/shape/shape-5.png') }}" alt="Shape">
                <img class="shape-6" src="{{ asset('assets/restaurant/images/shape/shape-7.png') }}" alt="Shape">
                <img class="shape-7" src="{{ asset('assets/restaurant/images/shape/shape-6.png') }}" alt="Shape">
            </div>
        </section>

    @endif

    @if ($bs->process_section == 1)
        <section class="store-area pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="section-title title-inline" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="title mb-0">{{ $bs->work_process_title }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        @if ($processes->count() > 0)
                            <div class="row justify-content-center">
                                @foreach ($processes as $process)
                                    <div class="col-sm-6 col-lg-6 col-xl-3" data-aos="fade-up">
                                        <div class="card mb-30">
                                            <div class="card-icon">
                                                <i class="{{ $process->icon }}"></i>
                                            </div>
                                            <div class="card-content">
                                                <a href="#">
                                                    <h3 class="card-title">{{ $process->title }}</h3>
                                                </a>
                                                <p class="card-text">{{ $process->text }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h3 class="text-center py-2" data-aos="fade-up" data-aos-delay="100">{{ __('No Data Found!') }}
                            </h3>
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
    @endif


    <!-- Template Start -->
    @if ($bs->template_section == 1)
        <section class="template-area pt-120 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->preview_templates_title }}</span>
                            <h2 class="title"> {{ $bs->preview_templates_subtitle }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center">
                            @foreach ($templates as $template)
                                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="50">
                                    <div class="card text-center mb-30">
                                        <div class="card-image">
                                            <a href="{{ detailsUrl($template) }}" class="lazy-container" target="_blank">
                                                <img class="lazyload lazy-image"
                                                    data-src="{{ asset('assets/front/img/template-previews/' . $template->template_img) }}"
                                                    alt="Demo Image" />
                                            </a>
                                        </div>
                                        <h4 class="py-3 theme-name">{{ __($template->theme_name) }}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (count($templates) > 0)
                            <div class="d-flex justify-content-center mb-5">
                                <a href="{{ route('front.templates') }}" class="btn primary-btn">
                                    {{ __('More Templates') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="shape">
                <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-1.png') }}" alt="Shape">
                <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
                <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-3.png') }}" alt="Shape">
                <img class="shape-4" src="{{ asset('assets/restaurant/images/shape/shape-4.png') }}" alt="Shape">
                <img class="shape-5" src="{{ asset('assets/restaurant/images/shape/shape-5.png') }}" alt="Shape">
                <img class="shape-6" src="{{ asset('assets/restaurant/images/shape/shape-7.png') }}" alt="Shape">
                <img class="shape-7" src="{{ asset('assets/restaurant/images/shape/shape-6.png') }}" alt="Shape">
            </div> --}}
        </section>
    @endif
    <!-- Template End -->


    @if ($bs->intro_section == 1)

        <section class="choose-area pt-120 pb-90">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="choose-content mb-30" data-aos="fade-right">
                            <span class="subtitle">{{ $bs->intro_title }}</span>
                            <h2 class="title">{{ $bs->intro_subtitle }}</h2>
                            <p class="text">{!! nl2br($bs->intro_text) !!}</p>
                            <div class="d-flex align-items-center">
                                @if ($bs->intro_section_button_url)
                                    <a href="{{ $bs->intro_section_button_url }}" target="_blank"
                                        class="btn primary-btn">
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

    @endif

    @if ($bs->pricing_section == 1)

        <section class="pricing-area pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->pricing_title }}</span>
                            <h2 class="title">{{ $bs->pricing_subtitle }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="nav-tabs-navigation text-center" data-aos="fade-up">
                            <ul class="nav nav-tabs">
                                @if (count($terms) > 1)
                                    @foreach ($terms as $term)
                                        <li class="nav-item">
                                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                data-bs-toggle="tab" data-bs-target="#{{ __("$term") }}"
                                                type="button">
                                                @if ($term == 'Month')
                                                    {{ __("$term" . 'ly') }}
                                                @endif
                                                @if ($term == 'Year')
                                                    {{ __("$term" . 'ly') }}
                                                @endif
                                                @if ($term == 'Lifetime')
                                                    {{ __("$term") }}
                                                @endif
                                            </button>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="tab-content">
                            @foreach ($terms as $term)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ __("$term") }}">
                                    @php
                                        $packages = Package::query()
                                            ->where('status', '1')
                                            ->where('featured', '1')
                                            ->where('term', strtolower($term))
                                            ->get();
                                    @endphp
                                    <div class="row justify-content-center">
                                        @foreach ($packages as $package)
                                            @php
                                                $pFeatures = json_decode($package->features);
                                            @endphp
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card mb-30 {{ $package->recommended == '1' ? 'active' : '' }}"
                                                    data-aos="fade-up" data-aos-delay="100">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon"><i class="{{ $package->icon }}"></i></div>
                                                        <div class="label">
                                                            <h3>{{ __($package->title) }}</h3>
                                                            @if ($package->recommended)
                                                                <span>{{ __('Recommended') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="text"></p>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="price">{{ $package->price != 0 && $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}{{ $package->price == 0 ? 'Free' : $package->price }}{{ $package->price != 0 && $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}</span>
                                                        @php
                                                            $termname = ucfirst($package->term);
                                                        @endphp
                                                        <span class="period">/ {{ __("$termname") }} </span>
                                                    </div>
                                                    <h5>{{ __('Whats Included') }}</h5>

                                                    <ul class="pricing-list list-unstyled p-0">
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Categories') }}
                                                            {{ $package->categories_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->categories_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Subcategories') }}
                                                            {{ $package->subcategories_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->subcategories_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Items') }}
                                                            {{ $package->items_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->items_limit . ')' }}
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-check"></i>
                                                            {{ __('Languages') }}
                                                            {{ $package->language_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->language_limit . ')' }}
                                                        </li>
                                                        @if (is_array($pFeatures) && in_array('Storage Limit', $pFeatures))
                                                            <li>
                                                                <i class=" fal fa-check"></i>
                                                                {{ __('Storage Limit') }}
                                                                @if ($package->storage_limit == 999999)
                                                                    {{ '(' . __('Unlimited') . ')' }}
                                                                @elseif ($package->storage_limit == 0 || $package->storage_limit == 999999)
                                                                    {{ __("$feature") }}
                                                                @elseif($package->storage_limit < 1024)
                                                                    {{ '(' . $package->storage_limit . 'MB )' }}
                                                                @else
                                                                    {{ '(' . ceil($package->storage_limit / 1024) . 'GB)' }}
                                                                @endif
                                                            </li>
                                                        @endif

                                                        @if (is_array($pFeatures) && in_array('Amazon AWS s3', $pFeatures))
                                                            <li>
                                                                <i class=" fal fa-check"></i>
                                                                {{ __('Amazon AWS s3') }}
                                                            </li>
                                                        @endif

                                                        @foreach ($allPfeatures as $feature)
                                                            <li
                                                                class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                                <i
                                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}"></i>
                                                                @if ($feature == 'Staffs')
                                                                    {{ __("$feature") }}
                                                                    @if (is_array($pFeatures) && in_array($feature, $pFeatures))
                                                                        {{ $package->staff_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->staff_limit . ')' }}
                                                                    @endif
                                                                @elseif($feature == 'Table Reservation')
                                                                    {{ __("$feature") . 's' }}
                                                                    {{ $package->table_reservation_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->table_reservation_limit . ')' }}
                                                                @elseif($feature == 'Online Order')
                                                                    {{ __("$feature") }}
                                                                @elseif($feature == 'Live Orders')
                                                                    {{ __('Realtime Order Refresh & Notification') }}
                                                                @else
                                                                    {{ __("$feature") }}
                                                                @endif
                                                            </li>
                                                            @if ($feature == 'Online Order')
                                                                <li
                                                                    class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? '' : 'disabled' }}">
                                                                    <i
                                                                        class="{{ is_array($pFeatures) && in_array($feature, $pFeatures) ? 'fal fa-check' : 'fal fa-times' }}">
                                                                    </i>
                                                                    {{ __('Orders') }}
                                                                    @if (is_array($pFeatures) && in_array($feature, $pFeatures))
                                                                        {{ $package->order_limit == 999999 ? '(' . __('Unlimited') . ')' : ' (' . $package->order_limit . ')' }}
                                                                    @endif

                                                                </li>
                                                            @endif
                                                        @endforeach

                                                    </ul>
                                                    <div class="d-flex align-items-center">
                                                        @if ($package->is_trial === '1' && $package->price != 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'trial', 'id' => $package->id]) }}"
                                                                class="btn secondary-btn">{{ __('Trial') }}</a>
                                                        @endif
                                                        @if ($package->price == 0)
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn primary-btn">{{ __('Signup') }}</a>
                                                        @else
                                                            <a href="{{ route('front.register.view', ['status' => 'regular', 'id' => $package->id]) }}"
                                                                class="btn primary-btn">{{ __('Purchase') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
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

    @endif

    @if ($bs->featured_users_section == 1)

        <section class="user-profile-area pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="section-title text-center" data-aos="fade-up">
                            @if (!empty($bs->featured_users_title))
                                <span class="subtitle">{{ $bs->featured_users_title }}</span>
                            @endif
                            @if (!empty($bs->featured_users_subtitle))
                                <h2 class="title">{{ $bs->featured_users_subtitle }}</h2>
                            @endif
                        </div>
                    </div>
                    @if ($featured_users->count() > 0)
                        <div class="col-12">
                            <div class="swiper user-slider">
                                <div class="swiper-wrapper">

                                    @foreach ($featured_users as $featured_user)
                                        <div class="swiper-slide">
                                            <div class="card" data-aos="fade-up" data-aos-delay="100">
                                                <div class="icon">
                                                    <img src="{{ $featured_user->image ? asset(Constant::WEBSITE_TENANT_USER_IMAGE . '/' . $featured_user->image) : asset('assets/front/img/user/profile.jpg') }}"
                                                        alt="User">
                                                </div>
                                                <div class="card-content">

                                                    <h3 class="card-title">
                                                        {{ $featured_user->restaurant_name }}
                                                    </h3>

                                                    <div class="social-link">
                                                        @foreach ($featured_user->social_media as $social)
                                                            <a href="{{ $social->url }}" target="_blank"><i
                                                                    class="{{ $social->icon }}"></i></a>
                                                        @endforeach
                                                    </div>
                                                    <div class="cta-btns">
                                                        <a href="{{ detailsUrl($featured_user) }}" target="_blank"
                                                            class="btn btn-sm secondary-btn rounded-pill">{{ __('View Website') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="swiper-pagination" data-aos="fade-up"></div>
                            </div>
                        </div>
                    @else
                        <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-center py-2">{{ __('No Featured User Found!') }}</h3>
                        </div>
                    @endif
                </div>
            </div>

            <div class="shape">
                <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-5.png') }}" alt="Shape">
                <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-2.png') }}" alt="Shape">
                <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-7.png') }}" alt="Shape">
            </div>
        </section>

    @endif

    @if ($bs->testimonial_section == 1)

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
                                                                <span
                                                                    class="designation">{{ $testimonials[$i]->rank }}</span>
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

    @endif

    @if ($bs->news_section == 1)

        <section class="blog-area ptb-90">
            <div class="container">

                <div class="section-title text-center" data-aos="fade-up">
                    @if (!empty($bs->blog_title))
                        <span class="subtitle">{{ $bs->blog_title }}</span>
                    @endif
                    @if (!empty($bs->blog_subtitle))
                        <h2 class="title">{{ $bs->blog_subtitle }}</h2>
                    @endif
                </div>
                <div class="row justify-content-center">
                    @if ($blogs->count() > 0)
                        @foreach ($blogs as $blog)
                            <div class="col-md-4 col-lg-4">
                                <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                                    <div class="card-image">
                                        <a href="{{ route('front.blog.details', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                            class="lazy-container aspect-ratio-16-9">
                                            <img class="lazyload lazy-image"
                                                src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                                data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                                alt="Blog Image">
                                        </a>
                                        <ul class="info-list">
                                            <li><i class="fal fa-user"></i>{{ __('Admin') }}</li>
                                            <li>
                                                <i
                                                    class="fal fa-calendar"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('F j, Y') }}
                                            </li>
                                            <li><i class="fal fa-tag"></i>{{ $blog->bcategory->name }}</li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <h4 class="card-title">
                                            <a
                                                href="{{ route('front.blog.details', ['id' => $blog->id, 'slug' => $blog->slug]) }}">
                                                {{ strlen($blog->title) > 120 ? mb_substr($blog->title, 0, 120, 'UTF-8') . '...' : $blog->title }}
                                            </a>
                                        </h4>
                                        <div class="card-text">
                                            {!! strlen($blog->content) > 120
                                                ? mb_substr(strip_tags($blog->content), 0, 120, 'UTF-8') . '...'
                                                : strip_tags($blog->content) !!}
                                        </div>
                                        <a href="{{ route('front.blog.details', ['id' => $blog->id, 'slug' => $blog->slug]) }}"
                                            class="card-btn">{{ __('Read More') }}</a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-center py-2">{{ __('No Blog Posts') }}</h3>
                        </div>
                    @endif
                </div>
            </div>

            <div class="shape">
                <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-10.png') }}" alt="Shape">
                <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-6.png') }}" alt="Shape">
                <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-1.png') }}" alt="Shape">
                <img class="shape-4" src="{{ asset('assets/restaurant/images/shape/shape-3.png') }}" alt="Shape">
            </div>
        </section>

    @endif

    @if ($bs->partners_section == 1)

        <section class="sponsor pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center" data-aos="fade-up">
                            <span class="subtitle">{{ $bs->partner_title }}</span>
                            <h2 class="title">{{ $bs->partner_subtitle }}</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        @if ($partners->count() > 0)
                            <div class="swiper sponsor-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($partners as $partner)
                                        <div class="swiper-slide">
                                            <div class="item-single d-flex justify-content-center" data-aos="fade-up"
                                                data-aos-delay="100">
                                                <div class="sponsor-img">
                                                    <a href="{{ $partner->url }}" target="blank">
                                                        <img class="lazyload blur-up"
                                                            src="{{ asset('assets/front/img/partners/' . $partner->image) }}"
                                                            alt="Sponsor">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination" data-aos="fade-up"></div>
                            </div>
                        @else
                            <h3 class="text-center py-2" data-aos="fade-up" data-aos-delay="100">
                                {{ __('No Partner Found!') }}</h3>
                        @endif
                    </div>
                </div>
            </div>

            <div class="shape">
                <img class="shape-1" src="{{ asset('assets/restaurant/images/shape/shape-10.png') }}" alt="Shape">
                <img class="shape-2" src="{{ asset('assets/restaurant/images/shape/shape-9.png') }}" alt="Shape">
                <img class="shape-3" src="{{ asset('assets/restaurant/images/shape/shape-7.png') }}" alt="Shape">
                <img class="shape-4" src="{{ asset('assets/restaurant/images/shape/shape-8.png') }}" alt="Shape">
                <img class="shape-5" src="{{ asset('assets/restaurant/images/shape/shape-1.png') }}" alt="Shape">
            </div>
        </section>

    @endif

@endsection
