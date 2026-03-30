@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Forgot'] ?? __('Forgot') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->forget_password_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->forget_password_meta_description : '')
@section('content')
    <section class="page-title-area d-flex align-items-center"
        style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{ $upageHeading?->forget_password_page_title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.client.dashboard', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                </li>
                                @if ($upageHeading?->forget_password_page_title)
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $upageHeading?->forget_password_page_title }}</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-content">
                        <div class="login-title">
                            <h3 class="title">{{ $keywords['Forgot_Password'] ?? __('Forgot Password') }}</h3>
                        </div>
                        <form action="{{ route('user.client.forgot.submit', getParam()) }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <span>{{ $keywords['Email_Address'] ?? __('Email Address') }} *</span>
                                <input type="email" name="email" value="{{ Request::old('email') }}">
                                @error('email')
                                    <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                @enderror
                                @if (Session::has('err'))
                                    <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                @endif
                            </div>
                            <div class="input-btn mt-4">
                                <div class="mt-2 d-flex justify-content-between">
                                    <button type="submit"
                                        class="main-btn">{{ $keywords['Send_Mail'] ?? __('Send Mail') }}</button>
                                    <a href="{{ route('user.client.login', getParam()) }}">
                                        {{ $keywords['Login_Now'] ?? __('Login Now') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
