@extends('front.layout')

@section('pagename')
    - {{$blog->title ?? __('Blog Details')}}
@endsection

@section('meta-description', !empty($blog) ? $blog->meta_keywords : '')
@section('meta-keywords', !empty($blog) ? $blog->meta_description : '')

@section('og-meta')
    <meta property="og:image" content="{{asset('assets/front/img/blogs/'.$blog->main_image)}}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
@endsection

@section('breadcrumb-title')
    {{strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30) . '...' : $blog->title}}
@endsection
@section('breadcrumb-link')
    {{__('Blog Details')}}
@endsection

@section('content')

    <div class="blog-details-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center gx-xl-5">
                <div class="col-lg-8">
                    <div class="blog-description mb-50">
                        <article class="item-single">
                            <div class="image">
                                <div class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                         data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Blog Image">
                                </div>
                            </div>
                            <div class="content">
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{__('Admin')}}</li>
                                    <li><i class="fal fa-calendar"></i>{{\Carbon\Carbon::parse($blog->created_at)->format("F j, Y")}}</li>
                                    <li><i class="fal fa-tag"></i>{{$blog->bcategory->name}}</li>
                                </ul>
                                <h3 class="title">
                                    {{$blog->title}}
                                </h3>
                                <p>{!! replaceBaseUrl($blog->content) !!}</p>

                            </div>
                        </article>
                    </div>
                    <div class="comments mb-30">
                        <div class="comment-lists">
                            <div id="disqus_thread"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @includeIf('front.partials.blog-sidebar')
                </div>
            </div>
        </div>
    </div>
  
@endsection

@if($bs->is_disqus == 1)
    @section('scripts')
     <script>
        var disqus_shortname = '{{$bs->disqus_shortname}}'
    </script>
     <script src="{{ asset('assets/front/js/custom.js') }}"></script>
   
    @endsection
@endif
