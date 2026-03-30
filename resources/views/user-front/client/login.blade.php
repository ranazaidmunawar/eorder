@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
    {{ $keywords['Login'] ?? __('Login') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->login_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->login_meta_description : '')
@section('content')


    @includeIf('user-front.breadcrum', ['title' => $upageHeading?->login_page_title])

    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (!empty(request()->input('redirected')) && request()->input('redirected') == 'checkout')
                        <a href="{{ route('user.product.front.checkout', [getParam(), 'type' => 'guest']) }}"
                            class="btn btn-block btn-primary mb-4 base-btn py-3">
                            {{ $keywords['Checkout_as_Guest'] ?? __('Checkout as Guest') }}
                        </a>
                        <div class="mt-4 mb-3 text-center login-or-title">
                            <h3 class="mb-0"><strong>{{ $keywords['OR'] ?? __('OR') }},</strong></h3>
                        </div>
                    @endif

                    <div class="login-content">

                        @if ($userBe->is_facebook_login == 1 || $userBe->is_google_login == 1)
                            <div class="social-logins mt-4 mb-4">
                                <div class="btn-group btn-group-toggle d-flex">
                                    @if ($userBe->is_facebook_login == 1)
                                        <a class="btn btn-primary text-white py-2 facebook-login-btn"
                                            href="{{ route('user.client.facebook.login', getParam()) }}"><i
                                                class="fab fa-facebook-f mr-2"></i>
                                            {{ $keywords['Login_via_Facebook'] ?? __('Login via Facebook') }}
                                        </a>
                                    @endif
                                    @if ($userBe->is_google_login == 1)
                                        <a class="btn btn-danger text-white py-2 google-login-btn"
                                            href="{{ route('user.client.google.login', getParam()) }}"><i
                                                class="fab fa-google mr-2"></i>
                                            {{ $keywords['Login_via_Google'] ?? __('Login via Google') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="login-title">
                            <h3 class="title">{{ $keywords['Login'] ?? __('Login') }}</h3>
                        </div>
                        <form id="loginForm" action="{{ route('user.client.login.submit', getParam()) }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <span>{{ $keywords['Email_Address'] ?? __('Email Address') }} *</span>
                                <input type="email" name="email">
                                @if (Session::has('err'))
                                    <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                @endif
                                @error('email')
                                    <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="input-box">
                                <span>{{ $keywords['Password'] ?? __('Password') }} *</span>
                                <input type="password" name="password">
                                @error('password')
                                    <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="input-box">
                                @if ($userBs->is_recaptcha == 1)
                                    <div class="d-block mb-4">
                                        <div id="g-recaptcha" class="g-recaptcha d-inline-block"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            @php
                                                $errmsg = $errors->first('g-recaptcha-response');
                                            @endphp
                                            <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="input-btn">
                                <button type="submit" class="main-btn">{{ $keywords['LOG_IN'] ?? __('LOG IN') }}</button>
                                <div class="mt-2 d-flex justify-content-between">
                                    <a href="{{ route('user.client.forgot', getParam()) }}"
                                        class="mr-3">{{ $keywords['Lost_your_password'] ?? __('Lost your password') }}
                                        ?</a>
                                    <a href="{{ route('user.client.register', getParam()) }}"
                                        class="mr-3">{{ $keywords["Don't_have_an_account"] ?? __("Don't have an account") }}
                                        ?</a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
