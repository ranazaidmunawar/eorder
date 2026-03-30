@php
    use Illuminate\Support\Carbon;
@endphp
@extends('front.layout')

@section('pagename')
    - {{__('Blog')}}
@endsection

@section('meta-description', !empty($seo) ? $seo->blogs_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->blogs_meta_keywords : '')

@section('breadcrumb-title')
    {{__('Blog')}}
@endsection
@section('breadcrumb-link')
    {{__('Blog')}}
@endsection

@section('content')
 
    <section class="blog-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">

                @foreach($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <article class="card mb-30" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-image">
                                <a href="{{route('front.blog.details',['id' => $blog->id,'slug' => $blog->slug])}}"
                                   class="lazy-container aspect-ratio-16-9">
                                    <img class="lazyload lazy-image"
                                         src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                         data-src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                         alt="Blog Image">
                                </a>
                                <ul class="info-list">
                                    <li><i class="fal fa-user"></i>{{__('Admin')}}</li>
                                    <li>
                                        <i class="fal fa-calendar"></i>{{Carbon::parse($blog->created_at)->format("F j, Y")}}
                                    </li>
                                    <li><i class="fal fa-tag"></i>{{$blog->bcategory->name}}</li>
                                </ul>
                            </div>
                            <div class="content">
                                <h4 class="card-title">
                                    <a href="{{route('front.blog.details',['id' => $blog->id,'slug' => $blog->slug])}}">
                                       {{ strlen($blog->title) > 120 ? mb_substr($blog->title, 0, 120, 'UTF-8') . '...' : $blog->title }}
                                    </a>
                                </h4>
                                <p class="card-text">{!! strlen($blog->content) > 120 ? mb_substr($blog->content, 0, 120, 'UTF-8') . '...' : $blog->content !!}</p>
                                <a href="{{route('front.blog.details',['id' => $blog->id,'slug' => $blog->slug])}}"
                                   class="card-btn">{{__('Read More')}}</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="pagination mb-30 justify-content-center">
                {{$blogs->appends(['category' => request()->input('category')])->links()}}
            </div>
        </div>
    </section>
  
@endsection
