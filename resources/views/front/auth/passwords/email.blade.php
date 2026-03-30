@extends('front.layout')

@section('pagename')
    - {{__("Reset Password")}}
@endsection

@section('meta-description', !empty($seo) ? $seo->forget_password_meta_description : '')
@section('meta-keywords', !empty($seo) ? $seo->forget_password_meta_keywords : '')

@section('breadcrumb-title')
    {{__("Reset Password")}}
@endsection
@section('breadcrumb-link')
    {{__("Reset Password")}}
@endsection

@section('content')
   
    <div class="authentication-area ptb-120">
        <div class="container">
            <div class="main-form">
                <div class="title">
                    <h3>{{__("Reset Password")}}</h3>
                </div>
                @if (session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('user.forgot.password.submit') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-30">
                        <span>{{__('Email Address')}}*</span>
                        <input type="email" name="{{__('email')}}" class="form-control" value="{{Request::old('email')}}">
                        @error('email')
                        <p class="text-danger mb-0 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button class="btn primary-btn w-100">{{ __('Send Password Reset Link') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
