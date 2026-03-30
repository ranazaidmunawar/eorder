@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Carbon\Carbon;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Blog'] ?? __('Blog') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->blogs_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->blogs_meta_description : '')

@section('content')


    @include('user-front.breadcrum', ['title' => $upageHeading?->blog_page_title])


    <section class="blog-area  pt-80 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-md-7 col-sm-8">
                        <div class="single-blog mt-30">
                            <div class="blog-thumb">

                                <img class="lazy wow fadeIn"
                                    onclick="window.location.href='{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}'"
                                    data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs) }}"
                                    alt="blog-image" data-wow-delay=".5s">
                            </div>
                            <div class="blog-content">
                                <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}">
                                    <h3 class="title">
                                        {{ strlen(convertUtf8($blog->title)) > 70 ? mb_substr(convertUtf8($blog->title), 0, 70, 'UTF-8') . '...' : convertUtf8($blog->title) }}
                                    </h3>
                                </a>
                                <p>
                                    {{ strlen(strip_tags(convertUtf8($blog->content))) > 100 ? substr(strip_tags(convertUtf8($blog->content)), 0, 100) . '...' : strip_tags(convertUtf8($blog->content)) }}
                                </p>
                                <div class="blog-comments d-block d-sm-flex justify-content-between align-items-center">
                                    <a
                                        href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}">{{ $keywords['Read_More'] ?? __('Read More') }}</a>
                                    <ul>
                                        @php
                                            app()->setLocale($userCurrentLang->code);
                                        @endphp
                                        <li>
                                            <i class="far fa-calendar-alt"></i>
                                            <span>{{ Carbon::parse($blog->created_at)->diffForHumans() }}</span>
                                            <span>|</span>
                                            <span>{{ getUser()->username }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center bg-light py-5 text-center">
                        <h3>{{ $keywords['NO BLOG POST FOUND!'] ?? __('NO BLOG POST FOUND!') }}</h3>
                    </div>
                @endforelse

                <div class="col-lg-12">
                    <div class="pagination-part">
                        {{ $blogs->appends(['category' => request()->input('category')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
