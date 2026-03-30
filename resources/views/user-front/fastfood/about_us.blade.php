@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use App\Models\User\Product;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use App\Models\User\ProductReview;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{$keywords['About Us'] ?? __('About Us') }}
@endsection


@section('meta-keywords', !empty($userSeo) ? $userSeo->home_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->home_meta_description : '')

@section('content')

     @include('user-front.breadcrum',['title' => $upageHeading?->about_page_title])

     <section class="pb-120"></section>
        <section class="experience-area ">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-end">
                    <div class="col-lg-6 col-md-8">
                        <div class="experience-content">
                            @if ($userBs->intro_section_title)
                                <div class="flag"><span>{{ convertUtf8($userBs->intro_section_title) }}</span></div>
                            @endif
                            <h3 class="title wow fadeIn" data-wow-duration="2000ms" data-wow-delay="0ms">
                                {{ convertUtf8($userBs->intro_title) }}</h3>
                            <p class=" wow fadeIns" data-wow-duration="2000ms" data-wow-delay="300ms">
                                {{ convertUtf8($userBs->intro_text) }}</p>

                            @if (!empty($userBs->intro_signature))
                                <img class="lazy wow fadeIn" data-wow-duration="2000ms" data-wow-delay="600ms"
                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_signature, $userBs) }}"
                                    alt="autograph">
                            @else

                            @endif
                            <i class="flaticon-burger"></i>
                        </div>
                    </div>
                </div>

            </div>
            @if ($userBs->intro_main_image)
                <div class="experience-bg">
                    <img class="lazy wow fadeIn"
                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBs->intro_main_image, $userBs) }}"
                        alt="experience">
                </div>
            @else

            @endif

        </section>

        <section class="team-area" style="{{ $members->count() == 0 ? 'background:#f1f1f1' : '' }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="section-title text-center">
                            <span>{{ convertUtf8($sectionHeading?->team_title) }} <img
                                    src="{{ asset('assets/front/img/title-icon.png') }}" alt=""></span>
                            <h3 class="title">{{ convertUtf8($sectionHeading?->team_subtitle) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @if ($members->count() > 0)
                        @foreach ($members as $member)
                            <div class="col-lg-4 col-md-7 col-sm-9">
                                <div class="single-team mt-30">
                                    <div class="team-thumb">
                                        @if ($member->image)
                                            <img class="lazy wow fadeIn"
                                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_MEMBER_IMAGES, $member->image, $userBs) }}"
                                                data-wow-delay=".5s" data-wow-duration="1s" alt="team">
                                        @endif
                                        <div class="team-overlay">
                                            <div class="link">
                                                <a><i class="flaticon-add"></i></a>
                                            </div>
                                            <div class="social">
                                                <ul>
                                                    @if ($member->facebook)
                                                        <li><a href="{{ $member->facebook }}"><i
                                                                    class="flaticon-facebook"></i></a></li>
                                                    @endif
                                                    @if ($member->twitter)
                                                        <li><a href="{{ $member->twitter }}"><i
                                                                    class="flaticon-twitter"></i></a></li>
                                                    @endif
                                                    @if ($member->instagram)
                                                        <li><a href="{{ $member->instagram }}"><i
                                                                    class="flaticon-instagram"></i></a></li>
                                                    @endif
                                                    @if ($member->linkedin)
                                                        <li><a href="{{ $member->linkedin }}"><i
                                                                    class="flaticon-linkedin"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="team-content text-center">
                                        <h4 class="title">{{ convertUtf8($member->name) }}</h4>
                                        <span>{{ convertUtf8($member->rank) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>{{ $keywords['NO_MEMBERS_FOUND!'] ?? __('NO MEMBERS FOUND!') }}</h3>
                    @endif
                </div>
            </div>
        </section>

        <section class="client-area bg_cover pt-105 pb-95 lazy"
            data-bg="{{ Uploader::getImageUrl(Constant::WEBSITE_IMAGE, $userBe->testimonial_bg_img, $userBs) }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="client-title text-center">
                            <h3 class="title">{{ convertUtf8($sectionHeading?->testimonial_title) }}</h3>

                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        @if ($testimonials->count() > 0)
                            <div class="client-items client-active">

                                @foreach ($testimonials as $testimonial)
                                    <div class="single-client">
                                        <div class="text">
                                            <p>{{ convertUtf8($testimonial->comment) }}</p>
                                        </div>
                                        <div class="client-info d-block d-sm-flex justify-content-between">
                                            <div class="item-1">
                                                @if ($testimonial->image)
                                                    <img class="lazy wow fadeIn"
                                                        data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_TESTIMONIAL_IMAGES, $testimonial->image, $userBs) }}"
                                                        alt="clients">
                                                @endif
                                                <span>{{ convertUtf8($testimonial->name) }}</span>
                                                <p>{{ convertUtf8($testimonial->rank) }}</p>
                                            </div>
                                            <div class="item-2 text-sm-right text-left">
                                                <ul>
                                                    @php
                                                        $i = 0;
                                                        for ($i == 1; $i < $testimonial->rating; $i++) {
                                                            echo '<li><i class="flaticon-star"></i></li>';
                                                        }
                                                    @endphp
                                                </ul>
                                                <span>({{ $testimonial->rating }} {{ __('Stars') }})</span>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <h3 class="text-center">{{ $keywords['NO CLIEND FOUND!'] ?? __('NO CLIEND FOUND!') }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </section>


@endsection
