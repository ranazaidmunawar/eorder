@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')

    {{ $keywords['Blog Details'] ?? __('Blog Details') }}
@endsection
@section('meta-keywords', "$blog->meta_keywords")
@section('meta-description', "$blog->meta_description")
@section('content')

    <section class="page-title-area d-flex align-items-center"
        style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $upageHeading?->blog_details_page_title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.front.index', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Home'] ?? __('Home') }}</a></li>
                                @if ($upageHeading?->blog_details_page_title)
                                    <li class="breadcrumb-item active" aria-current="page">

                                        {{ $upageHeading?->blog_details_page_title }}
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="blog-details-area pt-70 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details-items mt-50">
                        <div class="blog-thumb">
                            <img class="lazy wow fadeIn w-100"
                                data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs) }}"
                                alt="blog" data-wow-delay="1s">
                        </div>
                        <div class="blog-details-content">
                            <h2 class="title">{{ convertUtf8($blog->title) }}</h2>
                        </div>
                        <div class="tinymce-content">
                            <p>{!! $blog->content !!}</p>
                        </div>

                        <div class="blog-social">
                            <div class="shop-social d-flex align-items-center">
                                <span>{{ $keywords['Share'] ?? __('Share') }} :</span>
                                <ul>
                                    <li>
                                        <a
                                            href="//www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i
                                                class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a
                                            href="//twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"><i
                                                class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a
                                            href="//www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ convertUtf8($blog->title) }}"><i
                                                class="fab fa-linkedin"></i></a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="blog-details-comment">
                            <div class="comment-lists">
                                <div id="disqus_thread"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="blog-sidebar">
                        <div class="blog-box blog-border mt-50">
                            <div class="blog-title pl-45">
                                <h4 class="title"><i
                                        class="fa fa-list {{ $rtl == 1 ? 'mr-20 ml-10' : 'mr-10' }}"></i>{{ $keywords['All_Categories'] ?? __('All Categories') }}
                                </h4>
                            </div>
                            <div class="blog-cat-list pl-45 pr-45">
                                <ul>
                                    @foreach ($bcats as $key => $bcat)
                                        <li class="single-category @if (request()->input('category') == $bcat->id) active @endif">
                                            <a
                                                href="{{ route('user.front.blogs', [getParam(), 'term' => request()->input('term'), 'category' => $bcat->id]) }}">{{ convertUtf8(convertUtf8($bcat->name)) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


