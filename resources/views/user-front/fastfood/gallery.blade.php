@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
 {{$keywords['Gallery'] ?? __('Gallery') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->gallery_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->gallery_meta_description : '')
@section('content')

    @include('user-front.breadcrum',['title' => $upageHeading?->gallery_page_title])

    <section class="gallery-area pt-120 pb-90">
        <div class="container">
            @if($galleries->count() > 0)

            <div class="grid row">
                <div class="grid-sizer"></div>

                @foreach ($galleries as $key => $gallery)
                    <div class="single-gallery mb-30 col-lg-4 col-md-6">
                        <div class="item">
                            <img class="wow fadeIn" src="{{Uploader::getImageUrl(Constant::WEBSITE_GALLERY_IMAGES,$gallery->image,$userBs)}}" alt="gallery" data-wow-delay=".5s">
                            <div class="gallery-overlay">
                                <a class="image-popup"
                                   href="{{Uploader::getImageUrl(Constant::WEBSITE_GALLERY_IMAGES,$gallery->image,$userBs)}}"
                                   title="{{convertUtf8($gallery->title)}}">
                                    <i class="flaticon-add"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
             @else
             <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center text-center bg-light py-5">
                        <h3>{{ $keywords['NO_GALLERY_IMAGE_FOUND!'] ?? __('NO GALLERY IMAGE FOUND!') }}</h3>
                    </div>
                </div>
             </div>
            @endif
        </div>
    </section>

@endsection
