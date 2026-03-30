<!DOCTYPE html>
@php
    use App\Constants\Constant;
    use App\Http\Helpers\Uploader;
@endphp
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>Forget Password | {{ $userBs->website_title }}</title>
  	<link rel="icon" href="{{Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$userBs->favicon,$userBs)}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/forget.css')}}">
  </head>
  <body >
    <div class="login-page">
        <div class="form">
          <div class="text-center mb-4">
            <img class="login-logo" src="{{Uploader::getImageUrl(Constant::WEBSITE_LOGO,$userBs->logo,$userBs)}}" alt="">
          </div>
        @if (session()->has('success'))
          <div class="alert alert-success fade show" role="alert">
            <strong>Success!</strong> {{session('success')}}
          </div>
        @endif
        <form class="login-form" action="{{route('renter.forget.mail',getParam())}}" method="POST">
          @csrf
            <div class="form-group mb-0">
                <label>Email*</label>
            <input type="email" name="email" placeholder="{{ $keywords['Email_Address'] ?? __('Email Address') }}"/>
            @if ($errors->has('email'))
                <p class="text-danger text-left">{{$errors->first('email')}}</p>
            @endif
            </div>
            <button class="btn-primary w-100" type="submit">Submit</button>
        </form>

        <p class="back-link">
          <a href="{{route('renter.login',getParam())}}">&lt;&lt; Back</a>
        </p>
      </div>
    </div>
  </body>
</html>
