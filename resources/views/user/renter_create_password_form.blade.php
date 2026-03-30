<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{ $bs->website_title }}</title>
    <link rel="icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/forget.css') }}">
</head>

<body>
    <div class="login-page">
        <div class="form">
            @if (session()->has('success'))
                <div class="alert alert-success fade show" role="alert">
                    <strong>{{ __('Success') }}!</strong> {{ session('success') }} <a
                        href="{{ route('renter.login', getParam()) }}">Login Now</a>
                </div>
            @endif
            @if (session('link_error'))
                <div class="alert alert-danger">
                    {{ session('link_error') }}
                </div>
            @endif
            <div class="text-center mb-4">
                <img class="login-logo" src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="">
            </div>
            <form class="login-form" action="{{ route('renter.create.password.form.submit', getParam()) }}"
                method="POST">
                @csrf

                <input type="hidden" name="pass_token" value="{{ request('pass_token') }}">
                <div class="form-group">
                    <label for="">New Password*</label>
                    <input type="password" name="password" placeholder="{{ __('Enter new password') }}"
                        value="{{ old('password') }}" />
                    @error('password')
                        <p class="text-danger text-left">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Confirm Password*</label>
                    <input type="password" name="password_confirmation"
                        placeholder="{{ __('Enter confirm password') }}" value="{{ old('password_confirmation') }}" />
                    @error('password_confirmation')
                        <p class="text-danger text-left">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit">{{ __('Submit') }}</button>
            </form>


        </div>
    </div>



    <script src="{{ asset('assets/admin/js/core/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/core/bootstrap.min.js') }}"></script>
   
    <script src="{{ asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

</body>

</html>
