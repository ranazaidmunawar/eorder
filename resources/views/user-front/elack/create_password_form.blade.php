@extends('user-front.layout')

@section('pageHeading')
    {{ $keywords['New_Password'] ?? __('New Password') }}
@endsection

@section('style')
    @includeIf('user-front.elack.include.elack_css')
<style>
    :root {
        --elack-primary: #0f5156;
        --elack-bg: #f4f6f9;
        --elack-card: #ffffff;
    }

    body {
        background-color: var(--elack-bg);
    }

    .login-page-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .login-content-center {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .login-container {
        width: 100%;
        max-width: 440px;
    }

    .login-form-card {
        background: var(--elack-card);
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        text-align: center;
    }
    
    .login-branding {
        margin-bottom: 25px;
    }
    .login-branding i {
        font-size: 2.5rem;
        color: var(--elack-primary);
        margin-bottom: 10px;
    }
    .login-branding h2 {
        font-weight: 700;
        font-size: 1.5rem;
        color: #333;
        margin: 0;
    }

    .elack-input-group {
        text-align: left;
        margin-bottom: 15px;
    }
    .elack-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
    }
    .elack-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: #fff;
        transition: border-color 0.2s;
    }
    .elack-input:focus {
        border-color: var(--elack-primary);
        outline: none;
    }

    .login-submit-btn {
        background: var(--elack-primary);
        color: #fff;
        width: 100%;
        padding: 14px;
        border-radius: 8px;
        font-weight: 700;
        border: none;
        margin-top: 10px;
        cursor: pointer;
    }
    .login-submit-btn:hover { opacity: 0.9; }

    .form-footer-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        font-size: 0.8rem;
    }
    .form-footer-links a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="login-page-wrapper">
    <div class="login-content-center">
        <div class="login-container">
            <div class="login-form-card">
                <div class="login-branding">
                    <i class="fas fa-lock"></i>
                    <h2>{{ $keywords['New_Password'] ?? __('New Password') }}</h2>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success p-2 small mb-4">
                        {{ session('success') }} <a href="{{ route('user.client.login', getParam()) }}">{{ __('Login Now') }}</a>
                    </div>
                @endif
                
                @if (session('link_error'))
                    <div class="alert alert-danger p-2 small mb-4">
                        {{ session('link_error') }}
                    </div>
                @endif

                <form action="{{ route('user.client.password.create.submit', getParam()) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pass_token" value="{{ request('pass_token') }}">

                    <div class="elack-input-group">
                        <label class="elack-label">{{ $keywords['New_Password'] ?? __('New Password') }} *</label>
                        <input type="password" name="password" class="elack-input" placeholder="{{ __('New Password') }}" required>
                        @error('password')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="elack-input-group">
                        <label class="elack-label">{{ $keywords['Confirm_Password'] ?? __('Confirm Password') }} *</label>
                        <input type="password" name="password_confirmation" class="elack-input" placeholder="{{ __('Confirm Password') }}" required>
                        @error('password_confirmation')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="login-submit-btn">
                        {{ $keywords['Submit'] ?? __('Submit') }}
                    </button>
                </form>

                <div class="form-footer-links">
                    <a href="{{ route('user.client.login', getParam()) }}">{{ $keywords['Back_to_Login'] ?? __('Back to Login') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
