@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['New Password'] ?? __('New Password') }}
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
                        <h2 class="title">{{ $keywords['New Password'] ?? __('New Password') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.client.dashboard', getParam()) }}"><i
                                            class="flaticon-home"></i>{{ $keywords['Dashboard'] ?? __('Dashboard') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $keywords['New Password'] ?? __('New Password') }}</li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success fade show" role="alert">
                                <strong>{{ __('Success') }}!</strong> {{ session('success') }} <a href="{{ route('user.client.login',getParam()) }}">Login Now</a>
                            </div>
                        @endif
                        @if (session('link_error'))
                            <div class="alert alert-danger">
                                {{ session('link_error') }}
                            </div>
                        @endif
                        <form action="{{ route('user.client.password.create.submit', getParam()) }}" method="POST">
                            @csrf
                            <input type="hidden" name="pass_token" value="{{ request('pass_token') }}">
                            <div class="input-box">
                                <span>{{ $keywords['New Password'] ?? __('New Password') }} *</span>
                                <input type="password" name="password" value="{{ old('password') }}"
                                    placeholder="{{ $keywords['Password'] ?? __('Password') }}">
                                @error('password')
                                        <p class="text-danger text-left">{{ $message }}</p>
                                @enderror
                            </div>
                           
                              <div class="input-box">
                                <span>{{ $keywords['Confirm Password'] ?? __('Confirm Password') }} *</span>
                                <input type="password" name="password_confirmation"
                                    placeholder="{{ $keywords['password_confirmation'] ?? __('Confirm Password') }}" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                        <p class="text-danger text-left">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="input-btn mt-4">
                                <button type="submit" class="main-btn">{{ $keywords['Submit'] ?? __('Submit') }}</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
