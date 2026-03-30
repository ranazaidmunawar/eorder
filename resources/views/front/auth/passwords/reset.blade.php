@extends('front.layout')

@section('pagename')
  - {{ __('Reset Password') }}
@endsection
@section('breadcrumb-title')
  {{ __('Reset Password') }}
@endsection
@section('breadcrumb-link')
  {{ __('Reset Password') }}
@endsection

@section('content')
  <section class="authentication-area ptb-120">
    <div class="container">
      <div class="main-form">
        <div class="title">
          <h3>{{ __('Reset Password') }}</h3>
        </div>
        @if (session('success'))
          <div class="alert alert-success text-center" role="alert">
            {{ session('success') }} <a href="{{ route('user.login') }}">Login Now</a>
          </div>
        @elseif(session('link_error'))
          <div class="alert alert-danger text-center" role="alert">
            {{ session('link_error') }}
          </div>
        @endif
        <form action="{{ route('user.reset.password.submit') }}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="pass_token" value="{{ request('pass_token') }}">

          <div class="form-group mb-30">
            <span>{{ __('New Password') }}*</span>
            <input type="password" class="form-control" placeholder="{{ __('password') }}" name="password"
              value="{{ old('password') }}">
            @error('password')
              <p class="text-danger mb-0 mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-30">
            <span>{{ __('Confirm Password') }}*</span>
            <input type="password" class="form-control" placeholder="{{ __('confirm password') }}"
              name="password_confirmation" value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
              <p class="text-danger mb-0 mt-2">{{ $message }}</p>
            @enderror
          </div>

          <button class="btn primary-btn w-100">{{ __('Reset Password') }}</button>
        </form>
      </div>
    </div>
  </section>
@endsection
