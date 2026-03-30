
<aside class="sidebar-widget-area">

    <div class="widget widget-post mb-30">
        <h3 class="title">{{ __('Recent Posts')}}</h3>
        @foreach($allBlogs as $blog)
            <article class="article-item mb-30">
                <div class="image">
                    <a href="{{route('front.blog.details',['id' => $blog->id,'slug' => $blog->slug])}}" class="lazy-container aspect-ratio-1-1">
                        <img class="lazyload lazy-image" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                             data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Blog Image">
                    </a>
                </div>
                <div class="content">
                    <h6>
                        <a href="{{route('front.blog.details',['id' => $blog->id,'slug' => $blog->slug])}}">{{ $blog->title }}</a>
                    </h6>
                    <div class="time">
                        {{ $blog->created_at->diffForHumans() }}
                    </div>
                </div>
            </article>
        @endforeach
    </div>
    <div class="widget widget-social-link mb-30">
        <h3 class="title">{{__('Share')}}</h3>
        <div class="social-link">
            <a href="//www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="//twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="//www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title={{$blog->title}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
    <div class="widget widget-categories mb-30">
        <h3 class="title">{{__('Categories')}}</h3>
        <ul class="list-unstyled m-0">
            @foreach ($bcats as $key => $bcat)
            <li class="d-flex align-items-center justify-content-between @if(request()->input('category') == $bcat->id) active @endif">
                <a href="{{route('front.blogs', ['category'=>$bcat->id])}}"><i class="fal fa-folder"></i>{{$bcat->name}}</a>
                <span class="tqy">({{ $bcat->blogs_count }})</span>
            </li>
            @endforeach
        </ul>
    </div>
</aside>

