@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="blog-area blog-3 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <div class="section-title title-inline mb-50" data-aos="fade-up">
                        <div>
                            <h2 class="title color-white">{{ convertUtf8($userBs->blog_section_title) }}</h2>
                        </div>
                        <a href="{{ route('user.front.blogs', getParam()) }}" class="btn btn-lg btn-primary rounded-pill"
                            type="button" aria-label="Read Now">{{$keywords['Read More'] ??  __('Read More') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    @forelse ($blogs as $blog)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up">
                            <article class="card mb-30 radius-md p-20">
                                <div class="card-img">
                                    <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}"
                                        target="_self" title="Link" class="lazy-container ratio ratio-5-3">

                                        <img class="lazyload"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs) }}"
                                            alt="Blog Image">
                                    </a>
                                </div>
                                <div class="card-content">
                                    <ul
                                        class="card-list list-unstyled mb-20 rounded-pill px-3  py-2 justify-content-between shadow-md">
                                        <li class="icon-start">
                                          <a target="_self" title="{{ $blog->author }}"><i
                                                    class="fal fa-user"></i>{{ __('By') }} {{ $blog->author }}</a>
                                        </li>
                                        <li class="icon-start">
                                            <a target="_self" title=""><i
                                                    class="fal fa-calendar-check"></i>{{ \Carbon\carbon::parse($blog->created_at)->format('d.m.Y') }}</a>
                                        </li>
                                        @if ($blog->bcategory)
                                            <li class="icon-start">
                                                <a href="{{ route('user.front.blogs', [getParam(), 'category' => $blog->bcategory->id]) }}"
                                                    target="_self"
                                                    title="{{ $blog->bcategory ? $blog->bcategory->name : '' }}"><i
                                                        class="fal fa-tag"></i>{{ $blog->bcategory ? $blog->bcategory->name : '' }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                    <h4 class="card-title lc-1 mb-15">
                                        <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}"
                                            target="_self" title="{{ convertUtf8($blog->title) }}">
                                            {{ convertUtf8($blog->title) }}
                                        </a>
                                    </h4>
                                    <p class="card-text lc-3 mb-15">
                                        {{ strlen(strip_tags(convertUtf8($blog->content))) > 100 ? substr(strip_tags(convertUtf8($blog->content)), 0, 100) . '...' : strip_tags(convertUtf8($blog->content)) }}
                                    </p>
                                    <a href="{{ route('user.front.blog.details', [getParam(), $blog->slug, $blog->id]) }}"
                                        class="btn-text color-primary font-lg" target="_self"
                                        title="{{ $keywords['Read_More'] ?? __('Read More') }}">{{$keywords['Read More'] ?? __('Read More') }}</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <h3>{{$keywords['NO BLOG POST FOUND!'] ?? __('NO BLOG POST FOUND!') }}</h3>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
