@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['404'] ?? __('404') }}
@endsection
@section('content')
    
    <section class="page-title-area d-flex align-items-center"
             style="background-image:url('{{ asset('assets/restaurant/images/breadcrum.jpg')}}')">
          
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $keywords['404'] ?? __('404') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.user.detail.view', getParam()) }}">
                                        <i class="flaticon-home"></i>
                                       
                                        {{ $keywords['Home'] ?? __('Home')}}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $keywords['404'] ?? __('404') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="error-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="not-found">
                        <img src="{{asset('assets/front/img/404.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="error-div">
                        <div class="error-txt">
                        <div class="oops">
                            <img src="{{asset('assets/front/img/oops.png')}}" alt="">
                        </div>
                        <h2>{{ $keywords["Page Not Found"] ?? __('Page Not Found') }}</h2>
                        <a href="{{ route('front.user.detail.view', getParam()) }}"
                           class="go-home-btn">
                            {{ $keywords["Get Back to Home"] ?? __('Get Back to Home') }}
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
@endsection

