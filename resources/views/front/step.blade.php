@extends('front.layout')

@section('pagename')
    - {{$package->title}}
@endsection

@section('meta-description', !empty($package) ? $package->meta_keywords : '')
@section('meta-keywords', !empty($package) ? $package->meta_description : '')

@section('breadcrumb-title')
    {{$package->title}}
@endsection
@section('breadcrumb-link')
    {{$package->title}}
@endsection

@section('content')
  
    <div class="authentication-area pt-90 pb-120">
        <div class="container">
            <div class="main-form">
                <form id="#authForm" action="{{ route('front.checkout.view') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="title">
                        <h3>{{ __('Signup') }}</h3>
                    </div>
                    <div class="form-group mb-30">
                        <input type="text" class="form-control" name="username" placeholder="{{ __('Username') }}"
                               value="{{ old('username') }}" required>
                        @if ($hasSubdomain)
                            <p class="mb-0">
                                {{ __('Your subdomain based website URL will be') }}:
                                <strong class="text-primary"><span
                                        id="username">{username}</span>.{{env('WEBSITE_HOST')}}</strong>
                            </p>
                        @endif
                        <p class="text-danger mb-0" id="usernameAvailable"></p>
                        @error('username')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                               placeholder="{{  __('Email Address') }}" >
                        @error('email')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}"
                               placeholder="{{ __('Password') }}" >
                        @error('password')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-30">
                        <input class="form-control" id="password-confirm" type="password"
                               placeholder="{{ __('Confirm Password') }}" name="password_confirmation" 
                               autocomplete="new-password">
                        @error('password')
                        <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="id" value="{{ $id }}">
                    </div>
                    <button type="submit" class="btn primary-btn w-100"> {{ __('Continue') }} </button>
                </form>
            </div>
        </div>
    </div>
 
@endsection

@section('scripts')
  
<script>
 let hasSubdomain = "{{ $hasSubdomain }}";
</script>
<script src="{{ asset('assets/front/js/custom.js') }}"></script>
@endsection
