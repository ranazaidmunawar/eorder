<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{$bs->website_title}}</title>
    <link rel="icon" href="{{asset('assets/front/img/'.$bs->favicon)}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/login.css')}}">
</head>
<body>
<div class="login-page">
    <div class="text-center mb-4">
        <img class="login-logo" src="{{asset('assets/front/img/'.$bs->logo)}}" alt="">
    </div>
    <div class="form">
        @if (session()->has('alert'))
            <div class="alert alert-danger fade show" role="alert">
                <strong>{{__('Oops')}}!</strong> {{session('alert')}}
            </div>
        @endif
        <form class="login-form" action="{{route('admin.login.submit')}}" method="POST">
            @csrf
            <input type="text" name="username" value="{{ old('username') }}" placeholder="{{__('username')}}"/>
            @if ($errors->has('username'))
                <p class="text-danger text-left">{{$errors->first('username')}}</p>
            @endif
            <input type="password" name="password" value="{{ old('password') }}" placeholder="{{__('password')}}"/>
            @if ($errors->has('password'))
                <p class="text-danger text-left">{{$errors->first('password')}}</p>
            @endif
            <button type="submit">{{__('login')}}</button>
        </form>
        <a class="forget-link" href="{{route('admin.forget.form')}}">{{__('Forgot Password')}} ?</a>
    </div>
</div>



<script src="{{asset('assets/admin/js/core/jquery.min.js')}}"></script>

<script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

</body>
</html>
