@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
    use Illuminate\Support\Facades\Auth;

@endphp
<section class="blog-area blog-1 pt-100 pb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <div class="section-title title-inline mb-50" data-aos="fade-up">
                        <div>
                            <h2 class="title">{{ convertUtf8($userBs->blog_section_title) }}</h2>
                        </div>
                        <a href="{{ route('user.front.blogs',getParam()) }}" class="btn btn-lg btn-primary rounded-pill" type="button"
                            aria-label="Read Now">{{ $keywords['Read More'] ?? __('Read
                                                        More') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    @forelse ($blogs as $blog)
                        <div class="col-md-6 col-lg-3" data-aos="fade-up">
                            <article class="card mb-25 radius-md">
                                <div class="card-img">
                                    <a href="{{ route('user.front.blog.details', [getParam(),$blog->slug, $blog->id]) }}" target="_self"
                                        title="{{ convertUtf8($blog->title) }}" class="lazy-container ratio ratio-5-3">
                                        <img class="lazyload"
                                            data-src="{{ Uploader::getImageUrl(Constant::WEBSITE_BLOG_IMAGE, $blog->image, $userBs)}}"
                                            alt="Blog Image">
                                    </a>
                                </div>
                                <div class="card-content radius-md p-15">
                                    <ul class="card-list list-unstyled mb-15">
                                        <li class="font-xsm icon-start">
                                             <a target="_self" title="{{ $blog->author }}"><i
                                                    class="fal fa-user"></i>{{ __('By') }} {{ $blog->author }}</a>
                                        </li>
                                        <li class="font-xsm icon-start">
                                            <a  target="_self" title=""><i
                                                    class="fal fa-calendar-check"></i>
                                                {{ \Carbon\carbon::parse($blog->created_at)->format('d.m.Y') }}</a>
                                        </li>

                                        @if ($blog->bcategory)
                                            <li class="font-xsm icon-start">
                                                <a href="{{ route('user.front.blogs', [getParam(),'category' => $blog->bcategory->id]) }}"
                                                    target="_self" title="Link"><i class="fal fa-tag"></i>
                                                    {{ $blog->bcategory ? $blog->bcategory->name : '' }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                    <h5 class="card-title lc-2 mb-15">
                                        <a href="{{ route('user.front.blog.details', [getParam(),$blog->slug, $blog->id]) }}"
                                            target="_self" title="{{ convertUtf8($blog->title) }}">
                                            {{ convertUtf8($blog->title) }}
                                        </a>
                                    </h5>
                                    <a href="{{ route('user.front.blog.details', [getParam(),$blog->slug, $blog->id]) }}"
                                        class="btn-text color-primary" target="_self"
                                        title="{{ __('Read More') }}">{{ __('Read More') }}</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <h3>{{ __('No Blogs') }}</h3>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
