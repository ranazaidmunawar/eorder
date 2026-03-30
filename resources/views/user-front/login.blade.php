<!DOCTYPE html>
@php
use App\Constants\Constant;
use App\Http\Helpers\Uploader;
@endphp
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>Staff Login | {{ $userBs->website_title }}</title>
    <link rel="icon" href="{{Uploader::getImageUrl(Constant::WEBSITE_FAVICON,$userBs->favicon,$userBs)}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/forget.css')}}">
</head>

<body>
    <div class="login-page">
        <div class="form">
            <div class="image">
                <img class="login-logo" src="{{ Uploader::getImageUrl(Constant::WEBSITE_LOGO, $userBs->logo, $userBs) }}" alt="">
            </div>
            <h4 class="mb-3 mt-3">Staff Login</h4>

            <form action="{{ route('renter.login.submit', getParam()) }}" method="POST">
                @csrf
                @if (session()->has('alert'))
                <div class="alert alert-danger fade show" role="alert">
                    <strong>Oops!</strong> {{ session('alert') }}
                </div>
                @endif

                <div class="form-group mb-0">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="username"  id="username">
                    @if ($errors->has('username'))
                    <p class="text-danger text-left">{{ $errors->first('username') }}</p>
                    @endif
                </div>

                <div class="form-group mb-0">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="password" id="password">
                    @if ($errors->has('password'))
                    <p class="text-danger text-left">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <button class="btn-primary w-100" type="submit">Login</button>
            </form>
            <a class="forget-link" href="{{ route('renter.forget.form', getParam()) }}">Forgot Password ?</a>
        </div>
    </div>
</body>

</html>
