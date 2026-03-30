@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
@extends('user-front.layout')
@section('pageHeading')
 {{ $keywords['Register'] ?? __('Register') }}
@endsection
@section('meta-keywords', !empty($userSeo) ? $userSeo->sign_up_meta_keywords : '')
@section('meta-description', !empty($userSeo) ? $userSeo->sign_up_meta_description : '')
@section('content')

  <section class="page-title-area d-flex align-items-center"
    style="background-image: url('{{ $userBs->breadcrumb ? Uploader::getImageUrl(Constant::WEBSITE_BREADCRUMB, $userBs->breadcrumb, $userBs) : asset('assets/restaurant/images/breadcrum.jpg') }}');background-size:cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-item text-center">
                        <h2 class="title">{{$upageHeading?->signup_page_title}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="{{route('user.client.dashboard',getParam())}}"><i
                                            class="flaticon-home"></i>{{$keywords['Dashboard'] ?? __('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{$upageHeading?->signup_page_title}}</li>
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
                        @if(Session::has('sendmail'))
                            <div class="alert alert-success mb-4">
                                <p>{{Session::get('sendmail')}}</p>
                            </div>
                        @endif
                        <div class="login-title">
                            <h3 class="title">{{$keywords["Register"] ?? __('Register')}}</h3>
                        </div>
                        <form action="{{route('user.client.register.submit',getParam())}}" method="POST">@csrf
                            <div class="input-box">
                                <span>{{$keywords['Username'] ?? __('Username')}} *</span>
                                <input type="text" name="username" value="{{Request::old('username')}}">
                                @if ($errors->has('username'))
                                    <p class="text-danger mb-0 mt-2">{{$errors->first('username')}}</p>
                                @endif
                            </div>
                            <div class="input-box">
                                <span>{{$keywords['Email_Address'] ?? __('Email Address')}} *</span>
                                <input type="email" name="email" value="{{Request::old('email')}}">
                                @if ($errors->has('email'))
                                    <p class="text-danger mb-0 mt-2">{{$errors->first('email')}}</p>
                                @endif
                            </div>
                            <div class="input-box">
                                <span>{{$keywords['Password'] ?? __('Password')}} *</span>
                                <input type="password" name="password" value="{{Request::old('password')}}">
                                @if ($errors->has('password'))
                                    <p class="text-danger mb-0 mt-2">{{$errors->first('password')}}</p>
                                @endif
                            </div>
                            <div class="input-box mb-4">
                                <span>{{$keywords['Confirmation_Password'] ?? __('Confirmation Password')}} *</span>
                                <input type="password" name="password_confirmation"
                                       value="{{Request::old('password_confirmation')}}">
                                @if ($errors->has('password_confirmation'))
                                    <p class="text-danger mb-0 mt-2">{{$errors->first('password_confirmation')}}</p>
                                @endif
                            </div>

                            @if ($userBs->is_recaptcha == 1)
                                <div class="d-block mb-4">
                                    <div id="g-recaptcha" class="d-inline-block"></div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        @php
                                            $errmsg = $errors->first('g-recaptcha-response');
                                        @endphp
                                        <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                                    @endif
                                </div>
                            @endif
                            <div class="input-btn">
                                <button type="submit"
                                        class="main-btn">{{$keywords['Register'] ?? __('Register')}}</button>
                                <br>
                                <p>{{$keywords['Already_have_an_account_?'] ?? __('Already have an account ?')}}
                                    <a class="mr-3" href="{{route('user.client.login',getParam())}}">
                                        {{$keywords['Click_Here'] ?? __('Click Here')}}
                                    </a>
                                    {{$keywords['To_login'] ?? __('To login')}}
                                    .</p>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
