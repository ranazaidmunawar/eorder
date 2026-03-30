@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
 {{ $keywords['Teams'] ?? __('Teams') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->team_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->team_meta_description : '')
@section('content')

     @include('user-front.breadcrum',['title' => $upageHeading?->team_page_title])

    <section class="team-area team-page">
        <div class="container">

            <div class="row justify-content-start">
                @if($members->count() > 0)
                @foreach ($members as $item)
                    <div class="col-lg-4 col-md-7 col-sm-9">
                        <div class="single-team mt-30">
                            <div class="team-thumb">
                                <img class="lazy wow fadeIn"
                                     data-src="{{Uploader::getImageUrl(Constant::WEBSITE_MEMBER_IMAGES,$item->image,$userBs)}}" alt="team"
                                     data-wow-delay=".5s">
                                <div class="team-overlay">
                                    <div class="link">
                                        <a><i class="flaticon-add"></i></a>
                                    </div>
                                    <div class="social">
                                        <ul>
                                            @if($item->facebook)
                                                <li>
                                                    <a href="{{$item->facebook}}">
                                                        <i class="flaticon-facebook"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($item->twitter)
                                                <li>
                                                    <a href="{{$item->twitter}}">
                                                        <i class="flaticon-twitter"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($item->instagram)
                                                <li>
                                                    <a href="{{$item->instagram}}">
                                                        <i class="flaticon-instagram"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($item->linkedin)
                                                <li>
                                                    <a href="{{$item->linkedin}}">
                                                        <i class="flaticon-linkedin"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="team-content text-center">
                                <h4 class="title">{{convertUtf8($item->name)}}</h4>
                                <span>{{convertUtf8($item->rank)}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                 <div class="col-lg-12 text-center bg-light py-5">
                    <h3>{{ $keywords['NO_TEAM_FOUND!'] ?? __('NO TEAM FOUND!') }}</h3>
                 </div>
                @endif
            </div>
        </div>
    </section>

@endsection
